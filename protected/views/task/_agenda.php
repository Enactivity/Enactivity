<?
/**
 * @param $calendar TaskCalendar 
 * @param $showParent boolean defaults to true
 */

?>
<? foreach($calendar->datedTasks as $day => $times) : ?>
<article class="day">
	<? $daytime = strtotime($day); ?>
		
	<?= PHtml::openTag('h1', array(
		'id' => PHtml::dateTimeId($daytime),
		'class' => 'agenda-date',
	)); ?>
	<?= PHtml::encode(Yii::app()->format->formatDate($daytime)); ?>
	<?= PHtml::closeTag('h1'); ?>

	<? foreach($times as $time => $tasks): ?>
	<? foreach($tasks as $task): ?>
	<?= $this->renderPartial('/task/_view', array(
		'data'=>$task, 
		'showParent'=>$showParent,
	)); ?>
	<? endforeach; ?>
	<? endforeach; ?>
</article>
<? endforeach; ?>

<? if($calendar->hasSomedayTasks) {
	echo PHtml::openTag('h1', array('id' => 'someday-tasks'));
	echo 'Someday';
	echo PHtml::closeTag('h1');
	foreach($calendar->somedayTasks as $task) {
		if(!isset($task->starts)) {
			echo $this->renderPartial('/task/_view', array(
				'data'=>$task,
				'showParent'=>$showParent,
			));
		}
	}
} ?>