<?php

Yii::import('ext.widgets.ActiveForm');

/**
 *  
 * @author Ajay Sharma
 */
class TaskForm extends CWidget {

	public $goal;
	public $task;
	
	public function init() {
		parent::init();
		
		if(is_null($this->task)) {
			$this->task = new Task();
		}
		$this->task->goalId = $goal->id;
	}
	
	public function run() {
		Yii::app()->controller->renderPartial('/task/_form', array(
			'model' => $this->task,
			'goal' => $this->goal,
			'action' => array('/goal/createtask', 'id' => $goal->id),
		));
	}
}