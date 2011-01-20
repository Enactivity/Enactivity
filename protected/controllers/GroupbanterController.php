<?php

class GroupbanterController extends Controller
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
			$groupBanter = $this->loadModel($_GET['id']);
			$groupId = $groupBanter->groupId;
			$creatorId = $groupBanter->creatorId;
		}
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','create', 'reply'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view'),
				'expression'=>'$user->isGroupMember(' . $groupId . ')',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'delete'),
				'expression'=>'$user->id == ' . $creatorId,
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
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
		$groupBanter = $this->loadModel($id);
		
		$replies = new CActiveDataProvider('Group', array(
			'data' => $groupBanter->replies)
		);
		
		$reply = new GroupBanter();
		$reply->setScenario(GroupBanter::SCENARIO_REPLY);
		
		$this->render('view',array(
			'model'=>$groupBanter,
			'replies'=>$replies,
			'reply'=>$reply,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new GroupBanter;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GroupBanter']))
		{
			$model->attributes=$_POST['GroupBanter'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionReply($parentId)
	{
		$parentBanter = $this->loadModel($parentId);
		
		$model = new GroupBanter;
		$model->setScenario(GroupBanter::SCENARIO_REPLY);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GroupBanter']))
		{
			$model->attributes = $_POST['GroupBanter'];
			$model->parentId = $parentBanter->id;
			$model->groupId = $parentBanter->groupId;
			if($model->save())
				$this->redirect(array('view','id'=>$parentBanter->id));
		}

		$this->render('view',array(
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GroupBanter']))
		{
			$model->attributes=$_POST['GroupBanter'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
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
		// Handle creation actions
		$model = new GroupBanter;
		
		if(isset($_POST['GroupBanter']))
		{
			$model->attributes=$_POST['GroupBanter'];
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		
		// Show list of current banters
		$dataProvider = new CActiveDataProvider(
			GroupBanter::model()
				->scopeUsersGroups(Yii::app()->user->id)
				->parentless()
				->newestToOldest()
		);
		
		$this->render('index',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new GroupBanter('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GroupBanter'])) {
			$model->attributes=$_GET['GroupBanter'];
		}

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
		$model=GroupBanter::model()->findByPk((int)$id);
		if($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='group-banter-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}