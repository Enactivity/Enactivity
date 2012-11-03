<?php

Yii::import("application.components.web.Controller");

class MembershipController extends Controller
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
		return array(
			array('allow', // allow authenticated user
				'actions'=>array('index', 'join', 'leave', 'syncWithFacebook'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists user's groups
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Group', array(
			'data' => Yii::app()->user->model->allGroupUsers)
		);

		$this->render('index', array(
		    'dataProvider'=>$dataProvider,
		));
	}

	/** 
	 * Adds the current user to the specifiec group
	**/
	public function actionJoin($id) {

		if(Yii::app()->request->isPostRequest)
		{
			// we only allow trashing via POST request
			$model = $this->loadModel($id);
			$model->joinGroup();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderPartial('/membership/_view', array('data'=>$model), false, true);
				Yii::app()->end();
			}

			$this->redirect(array('index'));
		}
		
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionLeave($id) {
		
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow trashing via POST request
			$model = $this->loadModel($id);
			$model->leaveGroup();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderPartial('/membership/_view', array('data'=>$model), false, true);
				Yii::app()->end();
			}

			$this->redirect(array('index'));
		}
		
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

		/**
	 * Synchronize the current user's groups with facebook
	 */
	public function actionSyncWithFacebook() {
		if(Yii::app()->user->model->syncFacebookGroups()) {
			Yii::app()->user->setFlash('notice', "Your Facebook groups have been updated.");
		}

		$this->redirect(array('membership/index'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param mixed the integer ID or string slug of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = GroupUser::model()->findByPk((int) $id);
		if(isset($model)) {
			return $model;
		}

		throw new CHttpException(404, 'The requested page does not exist.');
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='membership-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}