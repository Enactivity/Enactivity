<?
/**
 * @param $calendar TaskCalendar 
 * @param $showParent boolean defaults to true
 */

?>
<div class="agenda">
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
		<article class="activity">
			<h1 class="activity-name">
				<i></i>
				<?= PHtml::link(PHtml::encode($activityInfo['activity']->name),
					array('activity/view', 'id'=>$activityId)
				); ?>
			</h1>
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
		</article>
		<? endforeach; ?>
		<? endforeach; ?>
	</article>
	<? endforeach; ?>

	<? if($calendar->hasSomedayTasks): ?>
	<article class="someday">
		<?= PHtml::openTag('h1', array('id' => 'someday-tasks')); ?>Someday</h1>
		<? foreach($calendar->somedayTasks as $activityId => $activityInfo): ?>
		<article class="activity">
			<h1 class='activity-name'>
				<i></i>
				<?= PHtml::link(
					PHtml::encode($activityInfo['activity']->name),
					array('activity/view', 'id'=>$activityId)
				); ?>
			</h1>
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
		</article>
		<? endforeach; ?>
	</article>
	<? endif; ?>
</div>