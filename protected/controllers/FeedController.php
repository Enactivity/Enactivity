<?php

class FeedController extends Controller
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
			array('allow',// allow authenticated user
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow', 
				'actions'=>array('view'),
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		$feedModel = new ActiveRecordLog();
		$feedDataProvider = new CActiveDataProvider(
			$feedModel->scopeUsersGroups(Yii::app()->user->id),
			array(
			)
		);

		$this->render('index', array(
			'dataProvider'=>$feedDataProvider,
		));
	}


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('_view',array(
			'data'=>$this->loadModel($id),
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ActiveRecordLog::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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
