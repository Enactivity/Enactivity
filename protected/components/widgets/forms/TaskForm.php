<?php

Yii::import('application.components.widgets.ActiveForm');

/**
 *  
 * @author Ajay Sharma
 */
class TaskForm extends CWidget {

	public $goal;
	public $task;
	
	public function init() {
		parent::init();
		
		if($this->goal == null) {
			throw new Exception("Dev didn't pass in Goal object to TaskForm widget");
		}
		
		if(is_null($this->task)) {
			$this->task = new Task();
		}
		$this->task->goalId = $this->goal->id;
	}
	
	public function run() {
		Yii::app()->controller->renderPartial('/task/_form', array(
			'model' => $this->task,
			'goal' => $this->goal,
			'action' => array('/goal/createtask', 'id' => $this->task->goalId),
		));
	}
}