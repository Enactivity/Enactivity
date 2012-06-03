<?php

class GroupController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
		array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('all','view'),
				'users'=>array('*'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'update', 'invite'),
				'users'=>array('@'),
		),
		array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create', 'admin', 'delete'),
				'expression'=>$user->isAdmin,
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
		// Get the group
		$group = $this->loadModel($id);
		
		// Get the list of the active group users
		$activemembers = $this->getMembersByStatus($group->id, GroupUser::STATUS_ACTIVE);
		
		// Get the list of the pending group users
		//$pendingmembers = $this->getMembersByStatus($group->id,  GroupUser::STATUS_PENDING);
				
		$this->render('view',array(
			'model'=>$group,
			'activemembers'=>$activemembers,
			//'pendingmembers'=>$pendingmembers,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Group;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Group']))
		{
			$model->attributes=$_POST['Group'];
			if($model->save())
			$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Group']))
		{
			$model->attributes=$_POST['Group'];
			if($model->save())
			$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
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
			if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists user's groups
	 */
	public function actionIndex()
	{
		$model=new Group('search');
		$model->unsetAttributes();  // clear any default values
		
		$dataProvider = $model->search();
		$dataProvider->criteria->addCondition("id IN (SELECT groupId AS id FROM group_user WHERE userId='" . Yii::app()->user->id . "')");
		$dataProvider->criteria->order = "name ASC";
		
		$this->render('index', array(
		        'model'=>$model,
		        'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionAll()
	{
		$dataProvider=new CActiveDataProvider('Group');
		$this->render('index', array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Group('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Group'])) {
			$model->attributes=$_GET['Group'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Invite a user to the group
	 */
	public function actionInvite()
	{
		$groupuser = new GroupUser;

		// un/comment the following code to enable/disable ajax-based validation
//		if(isset($_POST['ajax']) && $_POST['ajax']==='group-user-invite-form')
//		{
//		echo CActiveForm::validate($groupuser);
//		Yii::app()->end();
//		}

		// If form submitted
		if(isset($_POST['GroupUser']))
		{
			$groupuser->attributes=$_POST['GroupUser'];
			
			if(isset($_POST['User'])) {
				$user = User::model()->findByAttributes(array('email' => $_POST['User']['email']));
				if(!isset($user)) {
					//Create a new user with the email invited
					//FIXME: allows blank email??
					$user = new User('invite');
					$user->attributes = $_POST['User'];
					if($user->validate()) {
						if($user->save()) {
							// Get group
							$group = Group::model()->findByPk($_POST['GroupUser']['groupId']);
							
							// Send email
							$user->invite($group);
							Yii::app()->user->setFlash('invite', 'Your invitation has been sent.');
							$this->refresh();
						}
					}
				}
				$groupuser->userId = $user->id;
			}
			
			//Validate and save
			if($groupuser->validate())
			{
				//FIXME: throws an exception if user is already invited
				if($groupuser->save())
				$this->redirect(array('view','id'=>$groupuser->groupId));
			}
		}
		$this->render('invite', array('model'=>$groupuser));
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Group::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Get the list of users in this group filtered by status
	 * @param int $groupId
	 * @param String $status
	 * @return IDataProvider
	 */
	public function getMembersByStatus($groupId, $status) {
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		
		$dataProvider= $model->search();
		$dataProvider->criteria->addCondition(
			"id IN (SELECT userId AS id FROM group_user" 
				. " WHERE groupId='" . $groupId . "'" 
				. " AND status ='" . $status . "')"
		);
		$dataProvider->criteria->addCondition("status = '" . User::STATUS_ACTIVE .  "'");
		$dataProvider->criteria->order = "firstName ASC";
		
		return $dataProvider;
	}
}