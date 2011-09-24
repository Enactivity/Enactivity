<?php

class TaskController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			$task = $this->loadModel($_GET['id']);
			$groupId = $task->groupId;
		}
		else {
			$groupId = null;
		}

		return array(
		array('allow',
				'actions'=>array('index','create','calendar'),
				'users'=>array('@'),
		),
		array('allow', 
				'actions'=>array(
					'view','update','delete',
					'participate','unparticipate',
					'userComplete','userUncomplete',
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
		$model = $this->loadModel($id);
		$subtasks = $model->children()->findAll();
		$ancestors = $model->ancestors()->findAll();

		// handle new task
		$newTask = $this->handleNewTaskForm($id);

		$feedDataProvider = new CArrayDataProvider($model->feed);

		$this->render(
			'view', 
		array(
				'model' => $model,
				'subtasks' => $subtasks, 
				'ancestors' => $ancestors,
				'newTask' => $newTask,
				'feedDataProvider' => $feedDataProvider,
		)
		);
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($year = null, $month = null, $day = null)
	{
		$model = new Task();

		$attributes = array();
		
		if(isset($year)
		&& isset($month)
		&& isset($day)) {
			$model->startDate = $month . "/" . $day . "/" . $year;
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model = self::handleNewTaskForm(null, $model);

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Task']))
		{
			$model->attributes=$_POST['Task'];
			if($model->saveNode())
			$this->redirect(array('view','id'=>$model->id));
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
			$task = $this->loadModel($id);
			$task->trash();
			$task->saveNode();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderPartial('/task/_view', array('data'=>$task), false, true);
				Yii::app()->end();
			}
			$this->redirectReturnUrlOrView($task);
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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
			$task = $this->loadModel($id);
			$task->untrash();
			$task->saveNode();
				
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderPartial('/task/_view', array('data'=>$task), false, true);
				Yii::app()->end();
			}
			$this->redirectReturnUrlOrView($task);
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Adds the current user to task
	 * If add is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionParticipate($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow participating via POST request
			$task = $this->loadModel($id);
			$task->participate(Yii::app()->user->id);

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderPartial('/task/_view', array('data'=>$task), false, true);
				Yii::app()->end();
			}
			$this->redirectReturnUrlOrView($task);
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Removes current user from task
	 * If remove is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionUnparticipate($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow unparticipating via POST request
			$task = $this->loadModel($id);
			$task->unparticipate(Yii::app()->user->id);
				
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderPartial('/task/_view', array('data'=>$task), false, true);
				Yii::app()->end();
			}
			$this->redirectReturnUrlOrView($task);
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Marks the user as having completed the task
	 * If add is successful, the browser will be redirected to the parent's 'view' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionUserComplete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow completion via POST request
			$task = $this->loadModel($id);
			$task->userComplete(Yii::app()->user->id);

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderPartial('/task/_view', array('data'=>$task), false, true);
				Yii::app()->end();
			}
			$this->redirectReturnUrlOrView($task);
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Marks the user as having completed the task
	 * If add is successful, the browser will be redirected to the parent's 'view' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionUserUncomplete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow uncomplete via POST request
			$task = $this->loadModel($id);
			$task->userUncomplete(Yii::app()->user->id);
				
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderPartial('/task/_view', array('data'=>$task), false, true);
				Yii::app()->end();
			}
			$this->redirectReturnUrlOrView($task);
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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
			$task = $this->loadModel($id);
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
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CArrayDataProvider(
		Yii::app()->user->model->nextTasks,
		array(
				'pagination'=>false,
		)
		);
		
		$dataProviderSomeday = new CArrayDataProvider(
		Yii::app()->user->model->nextTasksSomeday,
		array(
			'pagination'=>false,
		)
		);

		// handle new task
		$newTask = $this->handleNewTaskForm();

		$this->render('index', array(
			'datedTasksProvider'=>$dataProvider,
			'datelessTasksProvider'=>$dataProviderSomeday, //FIXME: do a proper query
			'newTask'=>$newTask,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionCalendar($month=null, $year=null)
	{
		$monthObj = new Month($month, $year);

		$taskWithDateQueryModel = new Task();
		$datedTasks = new CActiveDataProvider(
		$taskWithDateQueryModel
		->scopeUsersGroups(Yii::app()->user->id)
		->scopeByCalendarMonth($monthObj->intValue, $monthObj->year),
		array(
				'criteria'=>array(
					'condition'=>'isTrash=0'
		),
				'pagination'=>false,
		)
		);

		$taskWithoutDateQueryModel = new Task();
		$datelessTasks = new CActiveDataProvider(
		$taskWithoutDateQueryModel
		->scopeUsersGroups(Yii::app()->user->id)
		->scopeNoWhen()
		->scopeLeaves(),
		array(
				'criteria'=>array(
					'condition'=>'isTrash=0'
		),
				'pagination'=>false,
		)
		);

		// handle new task
		$newTask = $this->handleNewTaskForm();

		$this->render('calendar', array(
				'datedTasksProvider'=>$datedTasks,
				'datelessTasksProvider'=>$datelessTasks,
				'newTask'=>$newTask,
				'month'=>$monthObj,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Task('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Task']))
		$model->attributes=$_GET['Task'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Task::model()->findByPk((int)$id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Return a new task based on POST data
	 * @param int $parentId the id of the new task's parent
	 * @param array $attributes attributes used to set default values
	 * @return $model if not saved
	 */
	public function handleNewTaskForm($parentId = null, $model = null) {
		if(is_null($model)) {
			$model = new Task(Task::SCENARIO_INSERT);
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Task'])) {
			$model->attributes=$_POST['Task'];
				
			if(isset($parentId)) {
				// tasks inherit parent time
				$parentTask = Task::model()->findByPk($parentId);
				$model->starts = $parentTask->starts;
				
				if($model->appendTo($parentTask)) {
					$this->redirect(array('view','id'=>$parentTask->id));
				}
			}
			else {
				if($model->saveNode()) {
					$this->redirect(array('view','id'=>$model->id));
				}
			}
		}

		return $model;
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
			$this->redirect(array('task/index'));
		}

		$this->redirect(
		isset($_POST['returnUrl'])
		? $_POST['returnUrl']
		: array('task/view', 'id'=>$task->id,));
	}
}
