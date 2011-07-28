<?php
/**
 * @param tasks Task[] 
 * @param showParent boolean
 */
// for($day = 1; $day <= $month->calendarDays; $day++) {
// 	$currentDayStart = mktime(0, 0, 0, $month->intValue, $day, $month->year);
// 	$currentDayEnd = mktime(23, 59, 59, $month->intValue, $day, $month->year);

// 	$htmlId = 'day-' . $day;
// 	echo PHtml::openTag('h1', array('id' => $htmlId));
// 	echo Yii::app()->format->formatDate($currentDayStart);
// 	echo PHtml::closeTag('h1');

// 	foreach($dataProvider->getData() as $task) {
// 		if((PDateTime::MySQLDateOffset($task->starts) <= $currentDayEnd)
// 		&& (PDateTime::MySQLDateOffset($task->starts) >= $currentDayStart)) {
// 			echo $this->renderPartial('_view', array('data'=>$task));
// 		}
// 	}
// }
//

$currentDate = null;
foreach($tasks as $task) {
	if(isset($task->starts)) {
		$taskDate = Yii::app()->format->formatDate(strtotime($task->starts));
		if($taskDate != $currentDate) {
			$currentDate = $taskDate;
			$htmlId = 'day-' . $task->startDate;
			echo PHtml::openTag('h1', array('id' => $htmlId));
			echo $currentDate;
			echo PHtml::closeTag('h1');
		}
		echo $this->renderPartial('_view', array(
			'data'=>$task, 
			'showParent'=>$showParent,
		));
	}
}
	
echo PHtml::openTag('h1', array('id' => 'no-start-tasks'));
echo 'Someday';
echo PHtml::closeTag('h1');
foreach($tasks as $task) {
	if(!isset($task->starts)) {
		echo $this->renderPartial('_view', array(
			'data'=>$task,
			'showParent'=>$showParent,
		));
	}
}