<?php
class TaskCalendar extends CComponent {
	
	private $days = array();
	private $someday = array();
	
	/**
	 * Construct a new Task Calendar using the tasks 
	 **/
	public function __construct($tasksArray = array()) {
		foreach ($tasksArray as $task) {
			$this->addTasks($task);
		}
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
	 * @return array of Tasks
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
	public function hasTasksByDate($date) {
		if(isset($this->days[$date])) {
			return true;
		}
		return false;
	}
	
	/**
	 * @return number of events in calendar
	 */
	public function getItemCount() {
		return sizeof($this->days) + sizeof($this->someday);
	}
}