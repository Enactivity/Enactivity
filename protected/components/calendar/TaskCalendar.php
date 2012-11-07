<?php

Yii::import("application.components.calendar.Month");

class TaskCalendar extends CComponent {
	
	private $months = array();
	private $weeks = array();
	private $days = array();
	private $someday = array();
	
	/**
	 * Construct a new Task Calendar using the tasks 
	 * @param array an array of Task models (allows nesting of arrays)
	 **/
	public function __construct($tasks = array()) {
		$this->addTasks($tasks);
	}

	public static function loadCalendarNextTasks() {
		$nextTasks = Task::nextTasksForUser(Yii::app()->user->model);
		return new TaskCalendar($nextTasks->data);
	}

	public static function loadCalendarByMonth($month) {
		$datedTasks = Task::tasksForUserInMonth(Yii::app()->user->id, $month);
		
		return new TaskCalendar($datedTasks->data);
	}

	public static function loadCalendarWithNoStart() {
		$datelessTasks = Task::tasksForUserWithNoStart(Yii::app()->user->id);
		return new TaskCalendar($datelessTasks->data);
	}

	/**
	 * Load a list of tasks into a calendar
	 * @param array $tasks list of tasks, allows for arrays of arrays too
	 */
	public function addTasks($tasks) {
		/** @var $task Task **/
		foreach ($tasks as $task) {
			if(is_array($task)) {
				$this->addTasks($task);
			}
			else {
				$this->addTask($task);
			}
		}
	}
	
	/**
	 * Adds a task to the calendar.
	 * @param Task
	 * @return null
	 **/
	public function addTask(Task $task) {
		if(isset($task->starts)) {
			// [date][time][activityId]['tasks'][]
			$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['tasks'][] = $task;

			if(isset($this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['activity'])) {
				$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['taskCount']++;
			}
			else {
				$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['activity'] = $task->activity->name;
				$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['taskCount'] = 1;
			}
		}
		else {
			// [activityId]['tasks']
			$this->someday[$task->activityId]['tasks'] = $task;
		}
	}
	
	/**
	 * @return array of Tasks in form $date => $time => {array of Tasks}
	 */
	public function getDatedTasks() {
		return $this->days;
	}
	
	/**
	 * @return array of Tasks
	 */
	public function getSomedayTasks() {
		return $this->someday;
	}
	
	/**
	 * Get all tasks on a given day
	 * @param string $date
	 * @return array of Tasks
	 */
	public function getTasksByDate($date) {
		$date = date('m/d/Y', strtotime($date));
		if(isset($this->days[$date])) {
			return $this->days[$date];
		}
		return array();
	}

	/**
	 * Are there any tasks in this calendar?
	 * @return boolean
	 **/
	public function getHasTasks() {
		foreach ($this->days as $date => $times) {
			foreach ($times as $time => $tasks) {
				if(isset($time[$task])) {
					return true;
				}
			}
		}

		return $this->hasSomedayTasks;
	}
	
	/**
	* Get if has tasks on a given day
	* @param string $date
	* @return array of Tasks
	*/
	public function hasTasksOnDate($date) {
		$date = date('m/d/Y', strtotime($date));
		return isset($this->days[$date]) && !empty($this->days[$date]);
	}
	
	/** 
	 * @return boolean true if calendar has tasks with no start date
	 **/
	public function getHasSomedayTasks() {
		return !empty($this->somedayTasks);
	}

	/**
	 * @return int number of tasks that occur in the calendar window 
	**/
	public function getDatedTaskCount() {
		$taskCount = 0;

		foreach ($this->days as $date => $times) {
			foreach ($times as $time => $tasks) {
				$taskCount += sizeof($tasks);
			}
		}
		return $taskCount;
	}

	/**
	 * @return int number of tasks that have no someday
	**/
	public function getSomedayTasksCount() {
		return sizeof($this->someday);
	}

	/**
	 * @return int number of events in calendar
	 */
	public function getTaskCount() {
		return $this->datedTaskCount + $this->somedayTasksCount;
	}

	/**
	 * @see getTaskCount
	 **/
	public function getItemCount() {
		return $this->taskCount;
	}
}