<?
/**
 * @param $calendar TaskCalendar 
 * @param $showParent boolean defaults to true
 */

?>
<? foreach($calendar->datedTasks as $date => $times) : ?>
<article class="day">
	<?= PHtml::openTag('h1', array(
		'id' => PHtml::dateTimeId($date),
		'class' => 'agenda-date',
	)); ?>
		<?= PHtml::encode(Yii::app()->format->formatDate($date)); ?>
	</h1>

	<? foreach($times as $time => $activities): ?>
	<? foreach($activities as $activityInfo): ?>
	<? foreach($activityInfo['tasks'] as $task): ?>
	<?= $this->renderPartial('/task/_view', array(
		'data'=>$task, 
	)); ?>
	<? endforeach; ?>
	<? endforeach; ?>
	<? endforeach; ?>
</article>
<? endforeach; ?>

<? if($calendar->hasSomedayTasks): ?>
<?= PHtml::openTag('h1', array('id' => 'someday-tasks')); ?>Someday</h1>
<? foreach($calendar->somedayTasks as $activityInfo): ?>
<? foreach($activityInfo['tasks'] as $task): ?>
<?= $this->renderPartial('/task/_view', array(
	'data'=>$task,
	'showParent'=>$showParent,
)); ?>
<? endforeach; ?>
<? endforeach; ?>
<? endif; ?>