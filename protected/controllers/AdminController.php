<?php

Yii::import("application.components.web.Controller");

class AdminController extends Controller
{

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(
					'summary', 'phpinfo', 'registrations'
				),
				'expression'=>'$user->isAdmin',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionSummary() {

		$userCount = User::model()->count();
		$groupCount = Group::model()->count();

		$activityCount = Activity::model()->count();
		$taskCount = Task::model()->count();
		$responseCount = Response::model()->count();
		
		$commentCount = Comment::model()->count();


		$this->render('summary',array(
			'userCount' => $userCount,
			'groupCount' => $groupCount,
			'activityCount' => $activityCount,
			'taskCount' => $taskCount,
			'responseCount' => $responseCount,
			'commentCount' => $commentCount,
		));
	}

	public function actionPhpInfo() {
		echo phpinfo();
	}

	/**
	 * Displays a the user registrations
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionRegistrations()
	{
		$dataProvider = new CActiveDataProvider('User', array(
		    'criteria'=>array(
		        'order'=>'created DESC',
		    ),
		    'pagination'=>array(
		        'pageSize'=>20,
		    ),
		));

		$previousPageUrl = $this->createUrl('', array(
			'user_page' => max(0, $dataProvider->pagination->currentPage - 1)
		));
		$nextPageUrl = $this->createUrl('', array(
			'user_page' => min(
				$dataProvider->pagination->pageCount, 
				$dataProvider->pagination->currentPage + 1
			)
		));

		$this->pageTitle = 'Registrations';

		$this->render('registrations',array(
			'previousPageUrl' => $previousPageUrl,
			'nextPageUrl' => $nextPageUrl,
			'users' => $dataProvider->data,
		));
	}
}