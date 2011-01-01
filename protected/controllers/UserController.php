<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
		return array(
		array('allow', 
				'actions'=>array('register', 'recoverpassword'),		
				'users'=>array('*')
		),
		array('allow', // allow only authenticated user to perform actions
				'actions'=>array('view', 'invite'),		
				'users'=>array('@'),
		),
		array('allow',
			'actions'=>array('update', 'updatepassword'),
			'expression'=>'$user->id == $_GET[\'id\']', 
		),
		array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index', 'admin', 'delete', 'update'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the home page.
	 * Users are created via Group Invites
	 */
	public function actionRegister($token)
	{		
		$model = $this->loadModelByToken($token);
		$model->setScenario(User::SCENARIO_REGISTER);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		//if user is already registered, get them outta here
		if(!Yii::app()->user->isGuest) {
			throw new CHttpException(400, 'Invalid request. You are currently logged in as a registered user.');
		}
		else if($model->status != User::STATUS_PENDING) {
			throw new CHttpException(400, 'Invalid request. This account has already registered.');
		}

		if(isset($_POST['User']))
		{	
			$model->attributes = $_POST['User'];
			$model->status = User::STATUS_ACTIVE;
			if($model->save()) {
				Yii::app()->user->setFlash('success', 'Your registration is complete, please sign-in.');
				$this->redirect(array('site/login'));
			}
		}

		$this->render('register',array(
			'model'=>$model,
		));
	}

	/**
	 * Form for recovering password
	 */
	public function actionRecoverPassword() {
		$form = new UserPasswordRecoveryForm();

		// if it is ajax validation request
//		if(isset($_POST['ajax']) && $_POST['ajax']==='password-recovery-form')
//		{
//			echo CActiveForm::validate($form);
//			Yii::app()->end();
//		}

		// collect user input data
		if(isset($_POST['UserPasswordRecoveryForm']))
		{
			$form->attributes = $_POST['UserPasswordRecoveryForm'];
			// validate user input and redirect to the previous page if valid
			if($form->validate()) {
				$form->recoverPassword();
			}
		}
		// display the login form
		$this->render('passwordrecovery', array('model'=>$form));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$model->setScenario(User::SCENARIO_UPDATE);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update', array(
			'model'=>$model,
		));
	}
	
/**
	 * Updates a user's password
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdatePassword($id)
	{
		$model = $this->loadModel($id);
		$model->setScenario(User::SCENARIO_UPDATE_PASSWORD);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));	
			}
		}
		else {
			// if the user hasn't attempted an upload yet, clean out their password
			$model->password = null;
		}

		$this->render('updatepassword', array(
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
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
		$model->attributes=$_GET['User'];

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
		$model=User::model()->findByPk((int)$id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param token the token of the model to be loaded
	 */
	public function loadModelByToken($token)
	{
		$model=User::model()->findByAttributes(array('token'=>$token));
		if($model === null) {
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
