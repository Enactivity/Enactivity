<?php
/**
 * Task UserCompleteButton class file
 * @author Ajay Sharma
 */

/**
 * UserCompleteButton displays an button that allows the user to
 * mark themself as having completed or uncompleted the task
 * @param Task  
 * @author Ajay Sharma
 */
class UserCompleteButton extends CWidget {
	
	/**
	 * @var Task task
	 */
	public $task = null;
	
	/**
	 * This method is called by CController::beginWidget()
	 */
	public function init()
	{
		if(is_null($this->task)) {
			throw exception ("No task passed into UserCompleteButton");
		}
	}
 
	public function run()
	{
		$this->render();
	}
	
	public function render() {
		if($this->task->isUserComplete) {
			echo PHtml::link(
				PHtml::encode('Uncomplete'), 
				array('/task/useruncomplete', 'id'=>$this->task->id),
				array(
					'class' => 'task_uncomplete_menu_item',
					'id' => 'task_uncomplete_menu_item' . $this->task->id,
					'submit'=>array(
						'task/useruncomplete',
						'id'=>$data->id,
					),
					'csrf' => true,
				)
			);
		}
		else {
			echo PHtml::link(
				PHtml::encode('Complete'), 
				array('/task/usercomplete', 'id'=>$this->task->id),
				array(
					'class' => 'task_complete_menu_item',
					'id' => 'task_complete_menu_item' . $this->task->id,
				)
			); 
		}
	}
}