<?php
/**
 * Task TrashButton class file
 * @author Ajay Sharma
 */

Yii::import('application.components.widgets.buttons.ButtonWidget');
/**
 * TrashButton displays an button for trashing or untrashing a Task
 * @param Task
 * @author Ajay Sharma
 */
class TrashButton extends ButtonWidget {
	
	protected function renderButton() {
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