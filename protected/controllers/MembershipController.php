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
		$memberships = User::model()->with(array(
			'allMemberships'=>array(),
		))->findByPk(Yii::app()->user->id)->allMemberships;

		$this->pageTitle = 'Groups';

		$this->render('index', array(
		    'memberships'=>$memberships,
		));
	}

	/** 
	 * Adds the current user to the specific group
	**/
	public function actionJoin($id) {

		if(Yii::app()->request->isPostRequest)
		{
			// we only allow trashing via POST request
			$model = $this->loadMembershipModel($id);
			$model->joinGroup();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderAjaxResponse('/membership/_view', array('data'=>$model));
			}

			$this->redirect(array('index'));
		}
		
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionLeave($id) {
		
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow trashing via POST request
			$model = $this->loadMembershipModel($id);
			$model->leaveGroup();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderAjaxResponse('/membership/_view', array('data'=>$model));
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