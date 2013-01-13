<?php

Yii::import("application.components.web.Controller");

class FeedController extends Controller
{

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{	
		return array(
			array('allow',// allow authenticated user
				'actions'=>array('index'),
				'users'=>array('@'),
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		$feedModel = new ActiveRecordLog();
		$feedDataProvider = new CActiveDataProvider(
			$feedModel->scopeUsersGroups(Yii::app()->user->id),
			array()
		);

		$this->pageTitle = 'Timeline';

		$this->render('index', array(
			'dataProvider'=>$feedDataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ActiveRecordLog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ActiveRecordLog']))
			$model->attributes=$_GET['ActiveRecordLog'];

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
		if(isset($_POST['ajax']) && $_POST['ajax']==='active-record-log-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
