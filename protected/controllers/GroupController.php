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
				'actions'=>array('all','view','slug'),
				'users'=>array('*'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'update', 'updateprofile', 'invite'),
				'users'=>array('@'),
		),
		array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create', 'admin', 'delete'),
				'expression'=>'$user->isAdmin',
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
	public function actionView($id = null, $slug = null)
	{
		// Get the group
		if(isset($id)) {
			$group = $this->loadModel($id);	
		}
		else {
			$group = $this->loadModel($slug);
		}
		
		// Get the list of the active group users
		$activemembers = $group->getMembersByStatus(GroupUser::STATUS_ACTIVE);
		
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
		$model = new Group;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Group']))
		{
			$model->attributes = $_POST['Group'];
			if($model->save()) {
				// create a group profile
				$profile = new GroupProfile;
				$profile->groupId = $model->id;
				$profile->save();
				
				$this->redirect(array('view','id'=>$model->id));
			}
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateProfile($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GroupProfile']))
		{
			$model->groupProfile->attributes = $_POST['GroupProfile'];
			if($model->groupProfile->save())
			$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('updateprofile',array(
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
		$dataProvider = $model->getGroupsByUser(Yii::app()->user->id);
		
		// If user is only in one group, redirect them to view group
		if($dataProvider->getItemCount() == 1) {
			$data = $dataProvider->getData();
			$id = reset($data)->id;
			$this->redirect(array('view','id'=>$id));
		}
		
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
		$inviteForm = new GroupInviteForm;

		// un/comment the following code to enable/disable ajax-based validation
//		if(isset($_POST['ajax']) && $_POST['ajax']==='invite-form-invite-form')
//		{
//			echo CActiveForm::validate($inviteForm);
//			Yii::app()->end();
//		}

		// If form submitted
		if(isset($_POST['GroupInviteForm'])) {
			$inviteForm->attributes = $_POST['GroupInviteForm'];
			if($inviteForm->validate()) {
				foreach($inviteForm->splitEmails($inviteForm->emails) as $email) {
					$user = User::model()->findByAttributes(array('email' => $email));
				
					if(!isset($user)) {
						//Create a new user with the email invite
						$user = new User('invite');
						$user->email = $email;
						$user->save('email');
					}
					
					// Get group
					$group = Group::model()->findByPk($inviteForm->groupId);
					
					if(is_null(GroupUser::model()->findByAttributes(array(
						'groupId' => $group->id,
						'userId' => $user->id,
					)))) {
						$groupuser = new GroupUser;
						$groupuser->groupId = $group->id;
						$groupuser->userId = $user->id;
						
						//Validate and save
						$groupuser->save();						
					}
					
					// Send email
					$user->sendInvitation(Yii::app()->user->model->fullName, $group->name);
					Yii::app()->user->setFlash('success', 'Your invitation has been sent.');
				}
				$this->redirect(array('view','id'=>$groupuser->groupId));
			}
		}
		
		// get user's groups
		$userGroups = Yii::app()->user->model->groups;
		
		$this->render('invite', 
			array(
				'model'=>$inviteForm,
				'userGroups'=>$userGroups,
			)
		);
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param mixed the integer ID or string slug of the model to be loaded 
	 */
	public function loadModel($idOrSlug)
	{
		$model = Group::model()->findByPk((int) $idOrSlug);
		if(isset($model)) {
			return $model;
		}
		$model = Group::model()->findBySlug($idOrSlug);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}