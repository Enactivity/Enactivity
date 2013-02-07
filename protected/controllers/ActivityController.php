<?php

Yii::import("application.components.calendar.TaskCalendar");
Yii::import("application.components.web.Controller");

Yii::import("ext.facebook.components.FacebookComment");

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
		// TODO: if no groupId, check if user = author

		return array(
			array('allow',
				'actions'=>array('create'),
				'users'=>array('@'),
			),
			array('allow', 
				'actions'=>array(
					'view','update',
					'trash','untrash',
					'start','resume',
					'feed','publish',
				),
				'expression'=>'Yii::app()->controller->isActivityAuthorOrGroupMember',
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

	public function getIsActivityAuthorOrGroupMember() {
		// get the group assigned to the event
		if(!empty($_GET['id'])) {
			$activity = $this->loadActivityModel($_GET['id']);

			if(StringUtils::isNotBlank($activity->groupId)) {
				return Yii::app()->user->isGroupMember($activity->groupId);
			}
			return strcasecmp(Yii::app()->user->id, $activity->authorId) == 0;
		}
		return false;
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
		$comment = $this->handleNewComment($model);
		$comments = $model->comments;

		$this->pageTitle = $model->name;

		$this->render('view',array(
			'model'=>$model,
			'calendar'=>$calendar,
			'comment' => $comment,
			'comments' => $comments,
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
			else if($form->publish($_POST['Activity'], $_POST['Task'])) {
				$this->redirect($form->activity->viewUrl);	
			}
		}

		$this->pageTitle = 'Create a New Activity';

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
		$form = new ActivityAndTasksForm();
		$form->activity = $this->loadActivityModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Activity']))
		{
			if($_POST['add_more']) { // adding more tasks
				$form->addMoreTasks($_POST['Activity'], $_POST['Task']);
			}
			else if($form->update($_POST['Activity'], $_POST['Task'])) {
				$this->redirect($form->activity->viewUrl);
			}
		}

		$this->pageTitle = 'Edit Activity';

		$this->render('update',array(
			'model'=>$form,
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

	public function actionFeed($id) {
		// load model
		$model = $this->loadActivityModel($id);

		// Feed
		$feedDataProvider = new CArrayDataProvider($model->feed);

		$this->pageTitle = 'Timeline for ' . $model->name;

		$this->render(
			'feed', 
			array(
				'model' => $model,
				'feedDataProvider' => $feedDataProvider,
			)
		);
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

		$this->pageTitle = 'Manage Activities';

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
			$this->redirect(Yii::app()->homeUrl);
		}

		$this->redirect(
			isset($_POST['returnUrl'])
			? $_POST['returnUrl']
			: array('activity/view', 'id'=>$activity->id,));
	}
}
