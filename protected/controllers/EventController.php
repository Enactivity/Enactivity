<?php

class EventController extends Controller
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
			$event = $this->loadModel($_GET['id']);
			$groupId = $event->groupId;
		}
		return array(
			// allow registered users to perform 'index' and 'create' actions
			array('allow',  
				'actions'=>array('index','create'),
				'users'=>array('@'),
			),
			// allow only group members to perform 'view', 'create' and 'update' actions
			array('allow',  
				'actions'=>array('view','update','delete'),
				'expression'=>'$user->isGroupMember(' . $groupId . ')',
			),
			// allow admin user to perform 'admin' and 'delete' actions
			array('allow', 
				'actions'=>array('admin','view','update','delete'),
				'expression'=>'$user->isAdmin',
			),
			// deny all users
			array('deny',  
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
		// Get the event
		$event = $this->loadModel($id);
		
		// check if the user RSVPed
		$eventuser = $this->checkRSVPForm($event->id);
		
		// Get the list of the attending users
		$attendees = $event->getAttendeesByStatus(EventUser::STATUS_ATTENDING);
		
		// Get the list of the not attending users
		$notattendees = $event->getAttendeesByStatus(EventUser::STATUS_NOT_ATTENDING);
				
		$this->render('view', array(
			'model'=>$event,
			'eventuser'=>$eventuser,
			'attendees'=>$attendees,
			'notattendees'=>$notattendees,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Event;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Event']))
		{
			$model->attributes=$_POST['Event'];
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

		if(isset($_POST['Event']))
		{
			$model->attributes=$_POST['Event'];
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
			$model = $this->loadModel($id);
			
			EventUser::model()->deleteAllByAttributes(array('eventId'=>$model->id));
			
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('event/index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all event's that the are in the user's groups.
	 */
	public function actionIndex()
	{
		$model = new Event('search');
		$dataProvider = new CActiveDataProvider(
			Event::model()->scopeUsersGroups(Yii::app()->user->id)->scopeFuture()
		);
		
		$this->checkRSVPForm($_POST['Event']['id']);
		
		$this->render('index', array(
		        'model'=>$model,
		        'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Event('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Event']))
			$model->attributes=$_GET['Event'];

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
		$model=Event::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='event-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Check if the user RSVPed and update as necessary
	 */
	protected function checkRSVPForm($eventId) {
		// check if the user RSVPed
		if(isset($_POST['Attending_Button'])) {
			$eventuser = EventUser::model()->setRSVP($eventId, Yii::app()->user->id, EventUser::STATUS_ATTENDING);
		}
		else if(isset($_POST['Not_Attending_Button'])) {
			$eventuser = EventUser::model()->setRSVP($eventId, Yii::app()->user->id, EventUser::STATUS_NOT_ATTENDING);
		} 
		else {
			// if the user did not post their RSVP, get their current RSVP
			$eventuser = EventUser::model()
				->scopeEvent($eventId)
				->scopeUser(Yii::app()->user->id)
				->find();
			$eventuser = $eventuser !== null ? $eventuser : new EventUser;
		}
		return $eventuser;
	}
}