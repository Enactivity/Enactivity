<?php
/**
 * @param datedTasks Task[] tasks with dates
 * @param datelessTasks Task[] task with no dates
 * @param showParent boolean
 */

// instantiate the arrays if needed
$datedTasks = empty($datedTasks) ? array() : $datedTasks;
$datelessTasks = empty($datelessTasks) ? array() : $datelessTasks;

?>
<section class='agenda'>
<?php 
$currentDate = null;
foreach($datedTasks as $task) {
	if(isset($task->starts)) {
		$taskDate = Yii::app()->format->formatDate(strtotime($task->starts));
		if($taskDate != $currentDate) {
			$currentDate = $taskDate;
			$htmlId = 'day-' . $task->startDate;
			echo PHtml::openTag('h1', array(
				'id' => $htmlId,
				'class' => 'agenda-date',
			));
			echo $currentDate;
			echo PHtml::closeTag('h1');
		}
		echo $this->renderPartial('_view', array(
			'data'=>$task, 
			'showParent'=>$showParent,
		));
	}
}

if(!empty($datelessTasks)) {
	echo PHtml::openTag('h1', array('id' => 'no-start-datedTasks'));
	echo 'Someday';
	echo PHtml::closeTag('h1');
	foreach($datelessTasks as $task) {
		if(!isset($task->starts)) {
			echo $this->renderPartial('_view', array(
				'data'=>$task,
				'showParent'=>$showParent,
			));
		}
	}
}
?>
</section>