<?php
/**
 * Task UserCompleteButton class file
 * @author Ajay Sharma
 */

Yii::import('application.components.widgets.buttons.ButtonWidget');
/**
 * UserCompleteButton displays an button that allows the user to
 * mark themself as having completed or uncompleted the task
 * @param Task  
 * @author Ajay Sharma
 */
class UserCompleteButton extends ButtonWidget {
	
	protected function renderButton() {
		if($data->isUserComplete) {
			echo PHtml::link(
				PHtml::encode('Resume'), 
				array('/task/useruncomplete', 'id'=>$data->id),
				array(
					'submit'=>array(
						'task/useruncomplete',
						'id'=>$data->id,
					),
					'csrf' => true,
					'id'=>'task-useruncomplete-menu-item-' . $data->id,
					'class'=>'task-useruncomplete-menu-item',
					'title'=>'Resume work on this task',
				)
			);
		}
		else {
			echo PHtml::link(
				PHtml::encode('Complete'), 
				array('/task/usercomplete', 'id'=>$data->id),
				array(
					'submit'=>array(
						'task/usercomplete',
						'id'=>$data->id,
					),
					'csrf' => true,
					'id'=>'task-usercomplete-menu-item-' . $data->id,
					'class'=>'task-usercomplete-menu-item',
					'title'=>'Finish working on this task',
				)
			); 
		}
	}
}