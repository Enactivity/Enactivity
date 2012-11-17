<?php

/**
 * ActivityAndTasksForm class.
 * ActivityAndTasksForm is the data structure for constructing
 * an activity and it's tasks.
 */
class ActivityAndTasksForm extends CFormModel
{
	public $activity;
	public $tasks = array();

	public function rules() {
		return array(
			array(
				'taskCount',
				'numerical',
				'min' => 1,
				'integerOnly'=>true
			),
		);
	}

	public function init() {
		$this->activity = new Activity();
		$this->tasks = array();
	}

	public function getTaskCount() {
		return sizeof($this->tasks);
	}

	public function addTasks($count) {
		for($i = 1; $i <= $count; $i++) {
			$this->addTask();
		}
	}

	public function addTask() {
		$index = sizeof($this->tasks) + 1; // start at 1 instead of 0 for user counting
		$this->tasks[$index] = new Task();
	}

	public function validate($attributes = null, $clearErrors = true) {

		$isValid = parent::validate();

		$isValid = $this->activity->validate($attributes, $clearErrors) && $isValid;

		foreach($this->tasks as &$task) {
			$isValid = $task->validate($attributes, $clearErrors) && $isValid;
		}

		return $isValid;
	}

	public function publish($activityAttributes = array(), $taskAttributesList = array()) {

		$this->activity->attributes = $activityAttributes;

		// Load in the new tasks
		foreach($taskAttributesList as $i => $taskAttributes) {
			$this->tasks[$i] = new Task();
			$this->tasks[$i]->attributes = $taskAttributes;
		}

		// Remove the tasks with no name (blanks hopefully)
		foreach ($this->tasks as $i => $task) {
			if(StringUtils::isBlank($task->name)) {
				unset($this->tasks[$i]);
			}
		}

		if($this->validate()) {
			$this->activity->draft();
			foreach($this->tasks as &$task) {
				$task->groupId = $this->activity->groupId;
				$task->activityId = $this->activity->id;
				$task->insertTask();
			}
			$this->activity->publish();

			return true;
		}

		return false;
	}
}