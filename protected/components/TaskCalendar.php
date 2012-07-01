<?php
class TaskCalendar extends CComponent {
	
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
		$nextTasks = TaskService::nextTasksForUser(Yii::app()->user->model);
		return new TaskCalendar($nextTasks->data);
	}

	public static function loadCalendarByMonth($month) {
		$datedTasks = TaskService::tasksForUserInMonth(Yii::app()->user->id, $month);
		$datelessTasks = TaskService::tasksForUserWithNoStart(Yii::app()->user->id);
		
		return new TaskCalendar(array(
			$datedTasks->data,
			$datelessTasks->data
		));
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
				if(isset($task->starts)) {
					$this->days[$task->startDate][$task->startTime][] = $task;
				}
				else {
					$this->someday[] = $task;
				}
			}
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
		if(isset($this->days[$date])) {
			return $this->days[$date];
		}
		return array();
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
	 * @return number of events in calendar
	 */
	public function getItemCount() {
		return sizeof($this->days) + sizeof($this->someday);
	}
}