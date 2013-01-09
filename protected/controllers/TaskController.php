<?php

Yii::import("application.components.calendar.Month");
Yii::import("application.components.calendar.TaskCalendar");
Yii::import("application.components.web.Controller");
Yii::import("application.components.introduction.TutorialActivityGenerator");

class TaskController extends Controller
{
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		// get the group assigned to the event
		if(!empty($_GET['id'])) {
			$task = $this->loadTaskModel($_GET['id']);
			$groupId = $task->groupId;
		}
		else {
			$groupId = null;
		}

		return array(
			array('allow',
				'actions'=>array('next','calendar','someday'),
				'users'=>array('@'),
			),
			array('allow', 
				'actions'=>array(
					'view','update','trash','untrash',
					'signup','start','resume',
					'complete','quit','ignore','feed',
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
		// load model
		$model = $this->loadTaskModel($id);
		$response = Response::loadResponse($model->id, Yii::app()->user->id);

		// Comments
		$comment = $this->handleNewComment($model);
		$comments = $model->comments;
		
		$this->render(
			'view',
			array(
				'model' => $model,
				'response' => $response,
				'comment' => $comment,
				'comments' => $comments,
			)
		);
	}

	public function actionFeed($id) {
		// load model
		$model = $this->loadTaskModel($id);

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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadTaskModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Task']))
		{
			if($model->updateTask($_POST['Task'])) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
			$task = $this->loadTaskModel($id);
			$task->trash();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderAjaxResponse('/task/_view', array('data'=>$task));
			}
			$this->redirectReturnUrlOrView($task);
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
			$task = $this->loadTaskModel($id);
			$task->untrash();
				
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderAjaxResponse('/task/_view', array('data'=>$task));
			}
			$this->redirectReturnUrlOrView($task);
		}
		else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Adds the current user to task
	 * If add is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionSignUp($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow participating via POST request
			Response::signUp($id, Yii::app()->user->id);
			$task = $this->loadTaskModel($id);

			// if AJAX request
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderAjaxResponse('/task/_view', array('data'=>$task));
			}
			$this->redirectReturnUrlOrView($task);
		}
		else {
			throw new CHttpException(405,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Starts the current user on the task
	 * If add is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionStart($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow participating via POST request
			Response::start($id, Yii::app()->user->id);
			$task = $this->loadTaskModel($id);

			// if AJAX request
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderAjaxResponse('/task/_view', array('data'=>$task));
			}
			$this->redirectReturnUrlOrView($task);
		}
		else {
			throw new CHttpException(405,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Removes current user from task
	 * If remove is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionQuit($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow unparticipating via POST request
			Response::quit($id, Yii::app()->user->id);
			$task = $this->loadTaskModel($id);
				
			// if AJAX request
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderAjaxResponse('/task/_view', array('data'=>$task));
			}
			$this->redirectReturnUrlOrView($task);
		}
		else {
			throw new CHttpException(405,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Removes current user from task
	 * If remove is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionIgnore($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow unparticipating via POST request
			Response::ignore($id, Yii::app()->user->id);
			$task = $this->loadTaskModel($id);
				
			// if AJAX request
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderAjaxResponse('/task/_view', array('data'=>$task));
			}
			$this->redirectReturnUrlOrView($task);
		}
		else {
			throw new CHttpException(405,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Marks the user as having completed the task
	 * If add is successful, the browser will be redirected to the parent's 'view' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionComplete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow completion via POST request
			Response::complete($id, Yii::app()->user->id);
			$task = $this->loadTaskModel($id);

			// if AJAX request
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderAjaxResponse('/task/_view', array('data'=>$task));
			}
			$this->redirectReturnUrlOrView($task);
		}
		else {
			throw new CHttpException(405,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Marks the user as having uncompleted the task
	 * If add is successful, the browser will be redirected to the parent's 'view' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionResume($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow uncomplete via POST request
			Response::resume($id, Yii::app()->user->id);
			$task = $this->loadTaskModel($id);
				
			// if AJAX request
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderAjaxResponse('/task/_view', array('data'=>$task));
			}
			$this->redirectReturnUrlOrView($task);
		}
		else {
			throw new CHttpException(405,'Invalid request. Please do not repeat this request again.');
		}
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow trashing via POST request
			$task = $this->loadTaskModel($id);
			$parentId = null;
			if(!$task->isRoot) {
				$parentId = $task->getParent()->id; // so we can use it for redirect
			}
				
			if($task->deleteNode()) {
				if(!is_null($parentId)) {
					$this->redirect(array('task/view', 'id'=>$parentId));
				}
				else {
					$this->redirect(array('task/index'));
				}
			}
			else {
				// Something went wrong
				Yii::app()->user->setFlash('error', 'There was an error deleting the Task, please try again later.');
				$this->redirect(array('task/view', 'id'=>$task->id));
			}
		}
		else {
			throw new CHttpException(405,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionNext()
	{
		// Get next tasks
		$calendar = TaskCalendar::loadCalendarNextTasks(Yii::app()->user->model);

		// Get list of user drafts
		$draftsCount = Yii::app()->user->model->draftsCount;

		// Generate an intro activity for first time users
		$introActvity = TutorialActivityGenerator::generateIntroActivity(Yii::app()->user->model);

		$this->render('next', array(
			'calendar'=>$calendar,
			'draftsCount'=>$draftsCount,
			'introActvity'=>$introActvity,
		));
	}

	/**
	 * Lists all tasks in a calendar.
	 */
	public function actionCalendar($month=null, $year=null)
	{
		$month = new Month($month, $year);
		$taskCalendar = TaskCalendar::loadCalendarByMonth(Yii::app()->user->model, $month);
		
		$this->render('calendar', array(
				'calendar'=>$taskCalendar,
				'newTask'=>$newTask,
				'month'=>$month,
			)
		);
	}

	/**
	 * Lists all tasks with no start date
	 **/
	public function actionSomeday() {
		$taskCalendar = TaskCalendar::loadCalendarWithNoStart(Yii::app()->user->model);

		$this->render('someday', array(
				'calendar'=>$taskCalendar,
			)
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Task('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Task'])) {
			$model->attributes=$_GET['Task'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Return a new task based on POST data
	 * @param int $activity the id of the new task's parent
	 * @param array $attributes attributes used to set default values
	 * @return Task if not saved, directs otherwise
	 */
	public function handleNewTaskForm($model = null) {
		if(is_null($model)) {
			$model = new Task(Task::SCENARIO_INSERT);
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		

		return $model;
	}
	
	/**
	 * Return a new task comment based on post data
	 * @param Task $task Task the user is commenting on
	 * @param Comment $comment
	 * @return Comment
	 */
	public function handleNewTaskComment($task, $comment = null) {
		if(is_null($comment)) {
			$comment = new TaskComment(TaskComment::SCENARIO_INSERT);
		}
		
		$comment->task = $task;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performCommentAjaxValidation($comment);
	
		if(isset($_POST['TaskComment'])) {
			if($comment->publishComment($task, $_POST['TaskComment'])) {
				$this->redirect(array('view','id'=>$task->id, '#'=>'comment-' . $comment->id));
			}
		}
	
		return $comment;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='task-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Redirect the current view to the return url value or
	 * to the task/view page if no return url is specified.
	 *
	 * If task is null, redirect to 'task/index'
	 *
	 * @param Task $task
	 */
	private function redirectReturnUrlOrView($task) {
		if(is_null($task)) {
			$this->redirect(Yii::app()->homeUrl);
		}

		if(Yii::app()->request->urlReferrer) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		else {
			$returnURL = isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('task/view', 'id'=>$task->id,);
			$this->redirect($returnURL);
		}
	}
}
