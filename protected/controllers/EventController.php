<?php

class EventController extends Controller
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
				'actions'=>array('index','view','create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','all'),
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
		// Get the event
		$event = $this->loadModel($id);
		
		// check if the user RSVPed
		if(isset($_POST['Attending_Button'])) {
			$eventuser = EventUser::model()->setRSVP($event->id, Yii::app()->user->id, EventUser::STATUS_ATTENDING);
		}
		else if(isset($_POST['Not_Attending_Button'])) {
			$eventuser = EventUser::model()->setRSVP($event->id, Yii::app()->user->id, EventUser::STATUS_NOT_ATTENDING);
		} 
		else {
			// if the user did not post their RSVP, get their current RSVP
			$eventuser = EventUser::model()->getRSVP($event->id, Yii::app()->user->id);
			$eventuser = $eventuser !== null ? $eventuser : new EventUser;
		}
		
		// Get the list of the attending users
		$attendees = $this->getAttendeesByStatus($event->id, EventUser::STATUS_ATTENDING);
		
		// Get the list of the not attending users
		$notattendees = $this->getAttendeesByStatus($event->id, EventUser::STATUS_NOT_ATTENDING);
				
		$this->render('view',array(
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
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all event's that the are in the user's groups.
	 */
	public function actionIndex()
	{		
		$model=new Event('search');
		$model->unsetAttributes();  // clear any default values
		
		$dataProvider= $model->search();
		$dataProvider->criteria->addCondition("id IN (SELECT id FROM event WHERE groupId IN (SELECT groupId FROM group_user WHERE userId='" . Yii::app()->user->id . "'))");
		$dataProvider->criteria->addCondition("ends > NOW()");
		$dataProvider->criteria->order = "starts ASC";
		
		$this->render('index', array(
		        'model'=>$model,
		        'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * List all events
	 */
	public function actionAll() 
	{		
		$dataProvider=new CActiveDataProvider('Event');
		$this->render('index', array(
			'dataProvider'=>$dataProvider,
			'myevents'=>$mygroupsevents,
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
	 * Get the list of users who have RSVPed with the given
	 * status value
	 * @param int $eventId
	 * @param String $status
	 * @return IDataProvider
	 */
	public function getAttendeesByStatus($eventId, $status) {
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		
		$dataProvider= $model->search();
		$dataProvider->criteria->addCondition(
			"id IN (SELECT userId AS id FROM event_user" 
				. " WHERE eventId='" . $eventId . "'" 
				. " AND status ='" . $status . "')"
		);
		$dataProvider->criteria->addCondition("status = '" . User::STATUS_ACTIVE .  "'");
		$dataProvider->criteria->order = "firstName ASC";
		
		return $dataProvider;
	}
}