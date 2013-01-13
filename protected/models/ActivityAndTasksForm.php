<?php

/**
 * ActivityAndTasksForm class.
 * ActivityAndTasksForm is the data structure for constructing
 * an activity and it's tasks.
 */
class ActivityAndTasksForm extends CFormModel
{
	const STARTING_TASK_COUNT = 5; //initial number of tasks to create

	const SCENARIO_DRAFT = 'draft';
	const SCENARIO_PUBLISH = 'publish';

	public $activity;
	public $tasks = array();

	public function rules() {
		return array(
			array(
				'taskCount',
				'numerical',
				'min' => 1,
				'integerOnly'=>true,
				'on' => self::SCENARIO_PUBLISH,
			),
		);
	}

	public function init() {
		$this->activity = new Activity();
		$this->addTasks(self::STARTING_TASK_COUNT);
	}

	public function getModels() {
		$models = array($this, $this->activity);
		return array_merge($models, $this->tasks);
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

	/**
	 * Override of CModel::setAttributes
	 * @param array ['activity', 'tasks' ]
	 */
	public function setAttributes($values, $safeOnly = true) {
		$this->activity->attributes = $values['activity'];

		// Load in the new tasks
		foreach($values['tasks'] as $i => $taskAttributes) {
			$this->tasks[$i] = new Task();
			$this->tasks[$i]->attributes = $taskAttributes;
		}
	}

	public function validate() {

		$isValid = parent::validate();

		$isValid = $this->activity->validate() && $isValid;

		foreach($this->tasks as &$task) {
			$isValid = $task->validate() && $isValid;
		}

		return $isValid;
	}

	public function draft($activityAttributes = array(), $taskAttributesList = array()) {
		$this->scenario = self::SCENARIO_DRAFT;

		// hacky way to ensure correct activity status
		$this->activity->scenario = Activity::SCENARIO_DRAFT;

		$this->attributes = array(
			'activity' => $activityAttributes,
			'tasks' => $taskAttributesList,
		);

		// Remove the tasks with no attributes
		foreach ($this->tasks as $i => $task) {
			if($task->isBlank) {
				unset($this->tasks[$i]);
			}
		}

		if($this->validate()) {
			$this->activity->draft();

			foreach($this->tasks as &$task) {
				$task->groupId = $this->activity->groupId;
				$task->activityId = $this->activity->id;
				$task->draft();
			}

			return true;
		}

		return false;
	}

	public function publish($activityAttributes = array(), $taskAttributesList = array()) {
		if($this->draft($activityAttributes, $taskAttributesList)) {
			$this->scenario = self::SCENARIO_PUBLISH;
			return $this->activity->publish($this->activity->attributes);
		}
		return false;
	}

	public function publishWithoutGroup($activityAttributes = array(), $taskAttributesList = array()) {
		if($this->draft($activityAttributes, $taskAttributesList)) {
			$this->scenario = self::SCENARIO_PUBLISH;
			return $this->activity->publishWithoutGroup($this->activity->attributes);
		}
		return false;
	}

	public function addMoreTasks($activityAttributes = array(), $taskAttributesList = array()) {
		$this->attributes = array(
			'activity' => $activityAttributes,
			'tasks' => $taskAttributesList,
		);

		$currentTaskCount = sizeof($taskAttributesList);
		$this->addTasks($currentTaskCount); // double it!
		return $drafted;
	}
}