<?php

Yii::import("application.components.web.Controller");

class LogController extends Controller
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
			array('allow',
				'actions'=>array('error'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	

	/**
	 * This is the action to log errors from the JS console
	 * @uses $_POST['message']
	 * @uses $_POST['url']
	 * @uses $_POST['line']
	 * @uses $_POST['navigator']
	 */
	public function actionError() {
		// we only allow submitting via POST request
		if(Yii::app()->request->isPostRequest) {
			$message = print_r(array(
				'message'=>$_POST['message'],
				'url'=>$_POST['url'],
				'line'=>$_POST['line'],
				'userAgent'=>$_POST['userAgent'],
			), true);
			Yii::log($message,'error','client-side');
		}
		else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}
}