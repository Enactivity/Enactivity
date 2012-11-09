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
	<? foreach($activities as $activityId => $activityInfo): ?>
	<h2><time><?= PHtml::encode($time); ?><time></h2>
	<ol>
	<? foreach($activityInfo['tasks'] as $task): ?>
		<li>
			<?= $this->renderPartial('/task/_view', array(
				'data'=>$task,
				'showParent'=>$showParent,
			)); ?>
		</li>
	<? endforeach; ?>
	</ol>
	<? endforeach; ?>
	<? endforeach; ?>
</article>
<? endforeach; ?>

<? if($calendar->hasSomedayTasks): ?>
<article class="someday">
	<?= PHtml::openTag('h1', array('id' => 'someday-tasks')); ?>Someday</h1>
	<? foreach($calendar->somedayTasks as $activityInfo): ?>
	<ol>
		<? foreach($activityInfo['tasks'] as $task): ?>
		<li>
			<?= $this->renderPartial('/task/_view', array(
				'data'=>$task,
				'showParent'=>$showParent,
			)); ?>
		</li>
		<? endforeach; ?>
	</ol>
	<? endforeach; ?>
</article>
<? endif; ?>