<?php
//TODO: investigate this class and redesign for Poncla
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
		$this->layout='splashlayout';
		
		// renders the view file 'protected/views/site/index.php' if not logged-in
		if(Yii::app()->user->isGuest) {
			$model=new ContactForm;
			if(isset($_POST['ContactForm']))
			{
				$model->attributes = $_POST['ContactForm'];
				if($model->validate())
				{
					$model->sendEmail();
				}
			}
			$this->render('index', array('model'=>$model));
		} 
		else {
			$this->redirect(array('task/index'));
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
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

	public function actionRegister() {
		// TODO?
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model = new UserLoginForm();

		// collect user input data
		if(isset($_GET['code']))
		{
			// validate user input and redirect to the previous page if valid
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
	
	/**
	 * Redirection for user settings
	 */
	public function actionSettings() 
	{
		$this->redirect(array('user/update'));
	}
	
	public function actionAdmin() {
		$this->render('admin', array());
	}
}