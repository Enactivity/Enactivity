<?php

class UserController extends Controller
{
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
		array('allow', // allow only authenticated user to perform actions
				'actions'=>array('invite', 'update'),
				'users'=>array('@'),
		),
		array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin', 'delete', 'update'),
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
	public function actionUpdate($id = null)
	{
		$model = null;
		if(is_null($id)) {
			$model = Yii::app()->user->model;
		}
		else { 
			$model = $this->loadModel($id);
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if($model->updateUser($_POST['User'])) {
			Yii::app()->user->setFlash('success', 'Your profile has been updated.');
			//TODO: redirect to profile screen if/when implemented
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
	public function actionUpdatePassword($id = null)
	{
		$model = null;
		if(is_null($id)) {
			$model = Yii::app()->user->model;
		}
		else {
			$model = $this->loadModel($id);
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if($model->updatePassword($_POST['User'])) {
			Yii::app()->user->setFlash('success', 'Your password has been updated.');
			$this->redirect(array('update'));
		}
		
		// clean out passwords to avoid leaks
		$model->password = null;
		$model->confirmPassword = null;

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
			if(!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		}
		else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
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
