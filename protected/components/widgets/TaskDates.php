<?php
/**
 * TaskDates class file.
 *
 * @author Ajay Sharma
 */

/**
 * TaskDates lists the dates of the tasks in a nice way 
 **/
class TaskDates extends CWidget
{
	/**
	 * The task whose data to display
	 * @var Task
	 */
	public $task;
	
	private $text;
	
	public function run() {
		if($this->task->hasStarts) {
			echo PHtml::openTag('time', array('class'=>'starts'));
			echo PHtml::link(
				PHtml::encode(Yii::app()->format->formatDateTime(strtotime($this->task->starts))), 
				array('task/update', 'id'=>$this->task->id),
				array()
			);
			echo PHtml::closeTag('time');
		}
		else {
			echo PHtml::openTag('time', array('class'=>'starts'));
			echo PHtml::link(
				PHtml::encode('Add start time'), 
				array('task/update', 'id'=>$this->task->id),
				array(
					'title' => PHtml::encode('Set ' . strtolower($this->task->getAttributeLabel('starts'))),
				)
			);
			echo PHtml::closeTag('time');
		}
		
		if($this->task->hasOnlyEnds) {
			echo PHtml::openTag('time', array('class'=>'ends'));
			echo PHtml::link(
				PHtml::encode(Yii::app()->format->formatDateTime(strtotime($this->task->ends))), 
				array('task/update', 'id'=>$this->task->id),
				array(
					'title' => PHtml::encode('Update ' . strtolower($this->task->getAttributeLabel('ends'))),
				)
			);
			echo PHtml::closeTag('time');
		}
		else if($this->task->hasEnds) {
			echo ' - ';
			echo PHtml::openTag('time', array('class'=>'ends'));
			echo PHtml::link(
				PHtml::encode(Yii::app()->format->formatTime(strtotime($this->task->ends))), 
				array('task/update', 'id'=>$this->task->id),
				array(
					'title' => PHtml::encode(Yii::app()->format->formatDateTime(strtotime($this->task->ends))),
				)
			);
			echo PHtml::closeTag('time');
		}
	}
}