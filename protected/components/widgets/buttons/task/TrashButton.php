<?php
/**
 * Task TrashButton class file
 * @author Ajay Sharma
 */

/**
 * TrashButton displays an button for trashing or untrashing a Task
 * @param Task
 * @author Ajay Sharma
 */
class TrashButton extends CWidget {
	
	/**
	 * @var CModel model
	 */
	public $task = null;
	
	/**
	 * This method is called by CController::beginWidget()
	 */
	public function init()
	{
		if(is_null($this->task)) {
			throw exception ("No task passed into TrashButton");
		}
	}
 
	public function run()
	{
		$this->render();
	}
	
	public function render() {
		if($this->task->isTrash) {
			echo PHtml::link(
				PHtml::encode('UnTrash'), 
				array('task/untrash', 'id'=>$this->task->id),
				array(
					'submit'=>array(
						'task/untrash',
						'id'=>$this->task->id,
					),
					'csrf' => true,
					'id'=>'task_untrash_menu_item' . $this->task->id,
				)
			);
		}
		else {
			echo PHtml::link(
				PHtml::encode('Trash'), 
				array('task/trash', 'id'=>$this->task->id),
				array(
					'submit'=>array(
						'task/trash',
						'id'=>$this->task->id,
					),
					'confirm'=>'Are you sure you want to trash this item?',
					'csrf' => true,
					'id'=>'task_trash_menu_item' . $this->task->id,
				)
			);
		}
	}
}