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
			echo PHtml::encode(Yii::app()->format->formatDateTimeAsAgo($this->task->startTimestamp));
			echo PHtml::closeTag('time');
		}
	}
}