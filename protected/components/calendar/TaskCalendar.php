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

	public static function loadCalendarNextTasks(User $user) {
		$nextTasks = $user->incompleteTasks;
		$futureTasks = $user->futureTasks;
		$somedayTasks = $user->somedayTasks;

		$calendar = new TaskCalendar(array(
			$nextTasks, 
			$futureTasks,
			$somedayTasks,
		));

		$ignorableTasks = $user->ignoredOrCompletedTasks;
		$calendar->removeTasks($ignorableTasks);

		$ignorableSomedayTasks = $user->ignoredOrCompletedSomedayTasks;
		$calendar->removeTasks($ignorableSomedayTasks);

		return $calendar;
	}

	public static function loadCalendarByMonth($user, $month) {
		$tasks = User::model()->with(array(
			'tasks'=>array(
				'scopes'=>array(
					'scopeByCalendarMonth' => array($month->monthIndex, $month->year),
				),
			),
		))->findByPk($user->id)->tasks;
		
		return new TaskCalendar($tasks);
	}

	public static function loadCalendarWithNoStart($user) {
		$tasks = User::model()->with(array(
			'tasks'=>array(
				'scopes'=>array(
					'scopeSomeday' => array(),
				),
			),
		))->findByPk($user->id)->tasks;

		return new TaskCalendar($tasks);
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

	public function removeTasks($tasks) {
		/** @var $task Task **/
		foreach ($tasks as $task) {
			if(is_array($task)) {
				$this->removeTasks($task);
			}
			else {
				$this->removeTask($task);
			}
		}
	}	
	
	/**
	 * Adds a task to the calendar.
	 * @param Task
	 * @return null
	 **/
	public function addTask(Task $task) {
		Yii::trace("Adding task {$task->id}", get_class($this));

		if($task->hasStarts) {
			$this->addTaskWithStartTime($task);
		}
		else {
			$this->addTaskWithNoStartTime($task);	
		}
	}

	protected function addTaskWithStartTime($task) {
		if($task->hasStarts) {
			if(isset($this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['activity'])) {
				$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['taskCount']++;
				$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['more']++;
			}
			else {
				$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['activity'] = $task->activity;
				$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['firstTask'] = $task;
				$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['taskCount'] = 1;
				$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['more'] = 0;
			}

			$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['tasks'][$task->id] = $task;

		}
		else {
			throw new CException("Attempting to add a task with start time, but task has no start time");
		}
	}

	protected function addTaskWithNoStartTime($task) {
		if(!$task->hasStarts) {

			if(isset($this->someday[$task->activityId]['activity'])) {
				$this->someday[$task->activityId]['taskCount']++;
				$this->someday[$task->activityId]['more']++;
			}
			else {
				$this->someday[$task->activityId]['activity'] = $task->activity;
				$this->someday[$task->activityId]['taskCount'] = 1;
				$this->someday[$task->activityId]['more'] = 0;
			}

			$this->someday[$task->activityId]['tasks'][$task->id] = $task;
		}
		else {
			throw new CException("Attempting to add a task with no start time, but task has a start time");
		}
	}

	public function removeTask($task) {
		Yii::trace("Removing task {$task->id}", get_class($this));

		if($task->hasStarts) {
			$this->removeTaskWithStartTime($task);
		}
		else {
			$this->removeTaskWithNoStartTime($task);
		}
	}

	protected function removeTaskWithStartTime($task) {
		if($task->hasStarts) {
			// [date][time][activityId]['tasks'][]
			if($this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['tasks'][$task->id]) {

				if(isset($this->days[$task->startDate][$task->formattedStartTime][$task->activityId])) {
					$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['taskCount']--;
					$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['more']--;

					if(empty($this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['tasks'])) {
						unset($this->days[$task->startDate][$task->formattedStartTime][$task->activityId]);

						if(empty($this->days[$task->startDate][$task->formattedStartTime])) {
							unset($this->days[$task->startDate][$task->formattedStartTime]);
						}

						if(empty($this->days[$task->startDate])) {
							unset($this->days[$task->startDate]);
						}
					}
					else {
						unset($this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['tasks'][$task->id]);
					}
				}
			}
		}
		else {
			throw new CException("Attempting to remove a task with start time, but task has no start time");
		}
	}

	protected function removeTaskWithNoStartTime($task) {
		if(!$task->hasStarts) {
			// [activityId]['tasks']
			if(isset($this->someday[$task->activityId]['tasks'][$task->id])) { // if record exists in hash

			if(isset($this->someday[$task->activityId]['activity'])) { // drop activity count
				$this->someday[$task->activityId]['taskCount']--;
				$this->someday[$task->activityId]['more']--;

				if($this->someday[$task->activityId]['taskCount'] <= 0) { // if was last task in hash for activity
					unset($this->someday[$task->activityId]);
				}
				else {
					unset($this->someday[$task->activityId]['tasks'][$task->id]);
				}
			}

			}
		}
		else {
			throw new CException("Attempting to remove a task with no start time, but task has a start time");
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
		$date = date(Task::DATE_FORMAT, strtotime($date));
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
		$date = date(Task::DATE_FORMAT, strtotime($date));
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