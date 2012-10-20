<?php
class SiteController extends Controller
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
				'actions'=>array('contact','error','index','login'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('logout'),
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
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// $this->layout='splashlayout';
		
		// renders the view file 'protected/views/site/index.php' if not logged-in
		if(Yii::app()->user->isGuest) {
			$this->render('index', array('model'=>$model));
		} 
		else {
			$this->redirect(array('task/index'));
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error = Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', array(
	    			'error' => $error,
	    	));
	    }
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		// collect user input data
		if(isset($_GET['code']))
		{
			// validate user input and redirect to the previous page if valid
			$model = new UserLoginForm();
			if($model->login($_GET)) {
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		elseif(isset($_GET['error_reason'])) { // Facebook login returned an error
			throw new CHttpException(401, $_GET['error_description']);
		}

		// If the user came here directly, kick them back to Facebook for login
		$this->redirect(Yii::app()->FB->loginUrl);
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionAdmin() {
		$this->render('admin', array());
	}
}