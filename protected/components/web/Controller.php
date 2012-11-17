<?php

Yii::import("application.components.widgets.MenuDefinitions");

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/defaultlayout';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'ensureAtLeastOneActiveMembershipForUser', // perform access control for CRUD operations
		);
	}

	/** 
	 * The filter method for 'ensureAtLeastOneActiveMembershipForUser'.  This filter will
	 * redirect the current user if they are logged in and have not yet activated a membership
	 * in at least one group.
	 * @return void
	 **/
	public function filterEnsureAtLeastOneActiveMembershipForUser($filterChain) {
		if(Yii::app()->user->isAuthenticated && Yii::app()->user->model->groupsCount <= 0) {
			Yii::app()->user->setFlash("notice", "Please select at least one group to use with " . Yii::app()->name);
			$this->redirect(array('membership/index'));
		}
		else {
			$filterChain->run();
		}
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadActivityModel($id)
	{
		$model = Activity::model()->findByPk($id);
		if(is_null($model)) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadCommentModel($id)
	{
		$model=Comment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadFeedModel($id)
	{
		$model=ActiveRecordLog::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param mixed the integer ID or string slug of the model to be loaded
	 */
	public function loadmembershipModel($id)
	{
		$model = membership::model()->findByPk((int) $id);
		if(isset($model)) {
			return $model;
		}

		throw new CHttpException(404, 'The requested page does not exist.');
	}	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Task
	 * @throws CHttpException
	 */
	public function loadTaskModel($id)
	{
		$model=Task::model()->findByPk((int)$id);
		if(is_null($model)) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadUserModel($id)
	{
		$model=User::model()->findByPk((int)$id);
		if(is_null($model)) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}
}