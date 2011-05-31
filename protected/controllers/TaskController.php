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
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'whatsnext'),
				'users'=>array('@'),
			),
			array('allow',  // allow only group members to perform 'updateprofile' actions
				'actions'=>array(
					'view','update','trash',
					'untrash','complete','uncomplete',
					'participate','unparticipate',
					'userComplete','userUncomplete',
				),
				'expression'=>'$user->isGroupMember(' . $groupId . ')',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin', 'delete'),
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
		
		// handle new task
		$newTask = $this->handleNewTaskForm($id);
		
		$this->render(
			'view', 
			array(
				'model' => $model,
				'newTask' => $newTask,
			)
		);
	}
	
	/**
	 *	Displays a list of upcoming user goals and tasks
	 */
	public function actionWhatsNext() {
		$model = $this->handleNewTaskForm();
		
		$this->render('whatsnext',array(
			'model'=>$model,
			'tasks'=>Yii::app()->user->model->nextTasks, 
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
			if($model->save())
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
			$task->save();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax'])) {
				$this->redirectReturnUrlOrView($task);
			}
			$this->renderPartial('/task/_view', array('data'=>$task));
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
			$task->save();
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax'])) {
				$this->redirectReturnUrlOrView($task);
			}
			$this->renderPartial('/task/_view', array('data'=>$task));
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
			$task->participate();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax'])) {
				$this->redirectReturnUrlOrView($task);
			}
			$this->renderPartial('/task/_view', array('data'=>$task));
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
			$task->unparticipate();
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax'])) {
				$this->redirectReturnUrlOrView($task);
			}
			$this->renderPartial('/task/_view', array('data'=>$task));
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
			$task->userComplete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax'])) {
				$this->redirectReturnUrlOrView($task);
			}
			$this->renderPartial('/task/_view', array('data'=>$task));
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
			$task->userUncomplete();
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax'])) {
				$this->redirectReturnUrlOrView($task);
			}
			$this->renderPartial('/task/_view', array('data'=>$task));
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
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// FIXME: only get tasks in user's groups
		$dataProvider = new CArrayDataProvider(
			Yii::app()->user->model->groupsParentlessTasks,
			array()
		);
		
		// handle new task
		$newTask = $this->handleNewTaskForm();
		
		$this->render('index', array(
			'dataProvider'=>$dataProvider,
			'newTask'=>$newTask,
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
	 * @return $model if not saved
	 */
	public function handleNewTaskForm($parentId = null) {
		$model = new Task(Task::SCENARIO_INSERT);
		
		if(isset($_POST['Task'])) {
			$model->attributes=$_POST['Task'];
			
			if(isset($parentId)) {
				$model->parentId = $parentId;
			}
			
			if($model->save()) {
				if(isset($model->parentId)) {
					$this->redirect(array('view','id'=>$model->parentId));
				}
				$this->redirect(array('view','id'=>$model->id));
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
	 * to the goal/view page if no return url is specified.
	 * @param Task $task
	 */
	private function redirectReturnUrlOrView($task) {
		$this->redirect(
			isset($_POST['returnUrl']) 
			? $_POST['returnUrl'] 
			: $this->redirectParentTask($task));
	}
	
	private function redirectParentTask($task) {
		$this->redirect(
			$task->hasParent 
			? array('task/view', 'id'=>$task->parentId, '#'=>'task-' . $task->id,) 
			: array('task/index', '#'=>'task-' . $task->id,));
	}
}
