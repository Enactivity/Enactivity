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
		$nextTasks = Task::nextTasksForUser($user);
		$futureTasks = Task::futureTasksForUser($user);
		$calendar = new TaskCalendar(array(
			$nextTasks->data, 
			$futureTasks->data,
		));

		$ignorableTasks = Task::ignorableTasksForUser($user);
		$calendar->removeTasks($ignorableTasks);

		$ignorableSomedayTasks = Task::ignorableSomedayTasksForUser($user);
		$calendar->removeTasks($ignorableSomedayTasks);

		return $calendar;
	}

	public static function loadCalendarByMonth($user, $month) {
		$datedTasks = Task::tasksForUserInMonth($user->id, $month);
		
		return new TaskCalendar($datedTasks);
	}

	public static function loadCalendarWithNoStart($user) {
		$datelessTasks = Task::tasksForUserWithNoStart($user->id);
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
		if($task->hasStarts) {
			$this->addTaskWithStartTime($task);
		}
		else {
			$this->addTaskWithNoStartTime($task);	
		}
	}

	protected function addTaskWithStartTime($task) {
		if($task->hasStarts) {
			$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['activity'] = $task->activity;
			$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['tasks'][$task->id] = $task;
			$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['taskCount']++;
		}
		else {
			throw new CException("Attempting to add a task with start time, but task has no start time");
		}
	}

	protected function addTaskWithNoStartTime($task) {
		if(!$task->hasStarts) {
			$this->someday[$task->activityId]['activity'] = $task->activity;
			$this->someday[$task->activityId]['tasks'][$task->id] = $task;
			$this->someday[$task->activityId]['taskCount']++;
		}
		else {
			throw new CException("Attempting to add a task with no start time, but task has a start time");
		}
	}

	public function removeTask($task) {
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
			unset($this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['tasks'][$task->id]);

			if(isset($this->days[$task->startDate][$task->formattedStartTime][$task->activityId])) {
				$this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['taskCount']--;

				if(empty($this->days[$task->startDate][$task->formattedStartTime][$task->activityId]['tasks'])) {
					unset($this->days[$task->startDate][$task->formattedStartTime][$task->activityId]);

					if(empty($this->days[$task->startDate][$task->formattedStartTime])) {
						unset($this->days[$task->startDate][$task->formattedStartTime]);
					}

					if(empty($this->days[$task->startDate])) {
						unset($this->days[$task->startDate]);
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
			unset($this->someday[$task->activityId]['tasks'][$task->id]);

			if(isset($this->someday[$task->activityId]['activity'])) {
				$this->someday[$task->activityId]['taskCount']--;

				if($this->someday[$task->activityId]['taskCount'] <= 0) {
					unset($this->someday[$task->activityId]);
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