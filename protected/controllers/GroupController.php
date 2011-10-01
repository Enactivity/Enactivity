<?php

class GroupController extends Controller
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
			$group = $this->loadModel($_GET['id']);
			$groupId = $group->id;
		}
		else {
			$groupId = null;
		}
		return array(
			array('allow', // allow authenticated user to view lists
				'actions'=>array('index', 'invite'),
				'users'=>array('@'),
			),
			array('allow',  // allow only group members to perform 'updateprofile' actions
				'actions'=>array('view'),
				'expression'=>'$user->isGroupMember(' . $groupId . ')',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create', 'admin', 'delete', 'update', 'view'),
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
		$dataProvider = new CActiveDataProvider('Group', array(
			'data' => Yii::app()->user->model->groups)
		);

		// If user is only in one group, redirect them to view group
// 		if($dataProvider->getItemCount() == 1) {
// 			$data = $dataProvider->getData();
// 			$id = reset($data)->id;
// 			$this->redirect(array('view','id'=>$id));
// 		}

		$this->render('index', array(
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
			if($inviteForm->validate() && $inviteForm->inviteUsers()) {
				$this->redirect(array('view','id'=>$inviteForm->groupId));
			}
		}

		// get user's groups
		if(Yii::app()->user->isAdmin) {
			$userGroups = Group::model()->findAll(array('order' => 'name'));
		}
		else {
			$userGroups = Yii::app()->user->model->groups;
		}

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