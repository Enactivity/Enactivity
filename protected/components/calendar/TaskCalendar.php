<?php

Yii::import("application.components.calendar.Month");

class TaskCalendar extends CComponent {

	private $dates = array();
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
	 * @param array $tasks list of tasks, allows for nested arrays too
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
	 * Removes a list of tasks from the calendar
	 * @param array $tasks list of tasks, allows for nested arrays too
	 **/
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
			$date = $task->startDate;
			$time = $task->formattedStartTime;
			$activityId = $task->activityId;

			if(isset($this->dates[$date][$time][$activityId]['activity'])) {
				$this->dates[$date][$time][$activityId]['taskCount']++;
				$this->dates[$date][$time][$activityId]['more']++;
			}
			else {
				$this->dates[$date][$time][$activityId]['activity'] = $task->activity;
				$this->dates[$date][$time][$activityId]['firstTask'] = $task;
				$this->dates[$date][$time][$activityId]['taskCount'] = 1;
				$this->dates[$date][$time][$activityId]['more'] = 0;
			}

			$this->dates[$date][$time][$activityId]['tasks'][] = $task;

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

			$this->someday[$task->activityId]['tasks'][] = $task;
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

			$date = $task->startDate;
			$time = $task->formattedStartTime;
			$activityId = $task->activityId;

			if($this->dates[$date][$time][$activityId]['tasks'][$task->id]) {

				if(isset($this->dates[$date][$time][$activityId])) {
					$this->dates[$date][$time][$activityId]['taskCount']--;
					$this->dates[$date][$time][$activityId]['more']--;

					if(empty($this->dates[$date][$time][$activityId]['tasks'])) {
						unset($this->dates[$date][$time][$activityId]);

						if(empty($this->dates[$task->startDate][$task->formattedStartTime])) {
							unset($this->dates[$task->startDate][$task->formattedStartTime]);
						}

						if(empty($this->dates[$task->startDate])) {
							unset($this->dates[$task->startDate]);
						}
					}
					else {
						unset($this->dates[$date][$time][$activityId]['tasks']);
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
		return $this->dates;
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
		if(isset($this->dates[$date])) {
			return $this->dates[$date];
		}
		return array();
	}

	/**
	 * Are there any tasks in this calendar?
	 * @return boolean
	 **/
	public function getHasTasks() {
		foreach ($this->dates as $date => $times) {
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
		return isset($this->dates[$date]) && !empty($this->dates[$date]);
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

		foreach ($this->dates as $date => $times) {
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

	/**
	 * Returns the key for task if it is found in the list, null otherwise.
	 * @return int|null
	 */
	private static function getIndexOfTask($task, $list) {
		foreach ($list as $key => $storedTask) {
			if(strcasecmp($storedTask->id, $task->id) == 0) {
				return $key;
			}
		}

		return null;
	}

	/** 
	 * Adds a task to a list, only if the task is not already in the list
	 * @param task to add
	 * @param array list of tasks
	 * @return array updated list
	 **/
	private static function addTaskToList($task, $list) {
		$index = self::getIndexOfTask($task, $list);
		
		if(is_null($index)) {
			$list[] = $task;
		}
		
		return $list;
	}

	/** 
	 * Removes the first instance of a task from a list of tasks
 	 * @param Task task to remove
	 * @param array list of tasks
	 * @return array updated list
	 */
	private static function removeTaskFromList($task, $list) {
		$index = self::getIndexOfTask($task, $list);
		
		if(isset($index)) {
			unset($list[$index]);
		}

		return $list;
	}
}