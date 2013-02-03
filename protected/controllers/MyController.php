<?php

Yii::import("application.components.calendar.Month");
Yii::import("application.components.calendar.TaskCalendar");
Yii::import("application.components.web.Controller");

class MyController extends Controller
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
				'actions'=>array('dashboard','calendar','someday','drafts','timeline','groups'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionDashboard()
	{
		// Get next tasks
		$calendar = TaskCalendar::loadCalendarNextTasks(Yii::app()->user->model);
		
		$this->pageTitle = 'Dashboard';

		$this->render('dashboard', array(
			'calendar'=>$calendar,
		));
	}

	/**
	 * Lists all tasks in a calendar.
	 */
	public function actionCalendar($month=null, $year=null)
	{
		$month = new Month($month, $year);
		$taskCalendar = TaskCalendar::loadCalendarByMonth(Yii::app()->user->model, $month);
		
		$this->pageTitle = Yii::app()->format->formatMonth($month->firstDayOfMonthTimestamp) . " " . $month->year;

		$this->render('calendar', array(
				'calendar'=>$taskCalendar,
				'newTask'=>$newTask,
				'month'=>$month,
			)
		);
	}

	/**
	 * Lists all tasks with no start date
	 **/
	public function actionSomeday() {
		$taskCalendar = TaskCalendar::loadCalendarWithNoStart(Yii::app()->user->model);

		$this->pageTitle = 'Someday';

		$this->render('someday', array(
				'calendar'=>$taskCalendar,
			)
		);
	}

	public function actionDrafts() {
		$drafts = Yii::app()->user->model->drafts;

		$this->pageTitle = 'Drafts';

		$this->render(
			'drafts',
			array(
				'activities' => $drafts,
			)
		);
	}


	/**
	 * Lists all models.
	 */
	public function actionTimeline()
	{
		
		$feedModel = new ActiveRecordLog();
		$feedDataProvider = new CActiveDataProvider(
			$feedModel->scopeUsersGroups(Yii::app()->user->id),
			array()
		);

		$this->pageTitle = 'Timeline';

		$this->render('/feed/index', array(
			'dataProvider'=>$feedDataProvider,
		));
	}

	
	/**
	 * Lists user's groups
	 */
	public function actionGroups()
	{
		$memberships = User::model()->with(array(
			'allMemberships'=>array(),
		))->findByPk(Yii::app()->user->id)->allMemberships;

		$this->pageTitle = 'Groups';

		$this->render('groups', array(
		    'memberships'=>$memberships,
		));
	}
}