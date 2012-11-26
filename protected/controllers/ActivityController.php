<?php

Yii::import("application.components.calendar.TaskCalendar");
Yii::import("application.components.web.Controller");

class ActivityController extends Controller
{

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		// get the group assigned to the event
		if(!empty($_GET['id'])) {
			$task = $this->loadActivityModel($_GET['id']);
			$groupId = $task->groupId;
		}
		else {
			$groupId = null;
		}

		return array(
			array('allow',
				'actions'=>array('index','create','calendar','someday'),
				'users'=>array('@'),
			),
			array('allow', 
				'actions'=>array(
					'view','update',
					'trash','untrash',
					'start','resume',
					'feed','publish',
					'tasks',
				),
				'expression'=>'$user->isGroupMember(' . $groupId . ')',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'expression'=>'$user->isAdmin',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadActivityModel($id);
		$calendar = new TaskCalendar($model->tasks);

		// Comments
		$comment = $this->handleNewActivityComment($model);
		$commentsDataProvider = new CArrayDataProvider($model->comments);

		$this->render('view',array(
			'model'=>$model,
			'calendar'=>$calendar,
			'comment' => $comment,
			'commentsDataProvider' => $commentsDataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$form = new ActivityAndTasksForm();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Activity']) && isset($_POST['Task']))
		{
			if($_POST['add_more']) { // adding more tasks
				$form->addMoreTasks($_POST['Activity'], $_POST['Task']);
			}
			elseif($_POST['draft']) {
				if($form->draft($_POST['Activity'], $_POST['Task'])) {
					$this->redirect(array('activity/view','id'=>$form->activity->id));
				}
			}
			else {
				if($form->publish($_POST['Activity'], $_POST['Task'])) {
					$this->redirect(array('activity/view','id'=>$form->activity->id));	
				}
			}
		}

		$this->render('create', array(
			'model' => $form,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadActivityModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Activity']))
		{
			if($model->updateActivity($_POST['Activity'])) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Publishes a particular model.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionPublish($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow trashing via POST request
			$activity = $this->loadActivityModel($id);
			$activity->publish();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderPartial('/activity/_view', array('data'=>$activity), false, true);
				Yii::app()->end();
			}
			$this->redirectReturnUrlOrView($activity);
		}
		else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}


	/**
	 * Trashes a particular model.
	 * If trash is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionTrash($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow trashing via POST request
			$activity = $this->loadActivityModel($id);
			$activity->trash();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderPartial('/activity/_view', array('data'=>$activity), false, true);
				Yii::app()->end();
			}
			$this->redirectReturnUrlOrView($activity);
		}
		else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Untrashes a particular model.
	 * If untrash is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionUntrash($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow untrashing via POST request
			$activity = $this->loadActivityModel($id);
			$activity->untrash();
				
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderPartial('/activity/_view', array('data'=>$activity), false, true);
				Yii::app()->end();
			}
			$this->redirectReturnUrlOrView($activity);
		}
		else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadActivityModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionTasks($id, $year = null, $month = null, $day = null, $time = null)
	{
		$activity = $this->loadActivityModel($id);

		$task = new Task();
		$task->activityId = $activity->id;
		$task->groupId = $activity->groupId;
		
		if(StringUtils::isNotBlank($year) 
		&& StringUtils::isNotBlank($month)
		&& StringUtils::isNotBlank($day)) {
			$task->startDate = $month . "/" . $day . "/" . $year;
		}

		if(StringUtils::isNotBlank($time)) {
			$task->startTime = $time;
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($task);

		if(isset($_POST['Task'])) {
			if($task->insertTask($_POST['Task'])) {
				Yii::app()->user->setFlash('success', $task->name . ' was created');
				if($_POST['add_more']) {
					$this->redirect(array('create',
						'activityId'=>$activity->id, 
						'year' => $task->startYear, 
						'month' => $task->startMonth, 
						'day' => $task->startDay,
						'time' => $task->startTime,
					));	
				}
				$this->redirect(array('/activity/view','id'=>$activity->id));
			}
		}

		$this->render('/task/create',array(
			'model'=>$task,
			'activity'=>$activity,
		));
	}


	public function actionFeed($id) {
		// load model
		$model = $this->loadActivityModel($id);

		// Feed
		$feedDataProvider = new CArrayDataProvider($model->feed);

		$this->render(
			'feed', 
			array(
				'model' => $model,
				'feedDataProvider' => $feedDataProvider,
			)
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Activity');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Activity('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Activity']))
			$model->attributes=$_GET['Activity'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='activity-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Redirect the current view to the return url value or
	 * to the activity/view page if no return url is specified.
	 *
	 * If activity is null, redirect to 'activity/index'
	 *
	 * @param Activity $activity
	 */
	private function redirectReturnUrlOrView($activity) {
		if(is_null($activity)) {
			$this->redirect(array('activity/index'));
		}

		$this->redirect(
			isset($_POST['returnUrl'])
			? $_POST['returnUrl']
			: array('activity/view', 'id'=>$activity->id,));
	}

		/**
	 * Return a new activity comment based on post data
	 * @param Activit $activity Activity the user is commenting on
	 * @param Comment $comment
	 * @return Comment
	 */
	public function handleNewActivityComment($activity, $comment = null) {
		if(is_null($comment)) {
			$comment = new ActivityComment(ActivityComment::SCENARIO_INSERT);
		}
		
		$comment->activity = $activity;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performCommentAjaxValidation($comment);
	
		if(isset($_POST['ActivityComment'])) {
			$comment->attributes=$_POST['ActivityComment'];
	
			if($comment->save()) {
				$this->redirect(array('view','id'=>$activity->id, '#'=>'comment-' . $comment->id));
			}
		}
	
		return $comment;
	}
}
