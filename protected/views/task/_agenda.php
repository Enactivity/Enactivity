<?
/**
 * @param $calendar TaskCalendar 
 * @param $showParent boolean defaults to true
 */

?>
<? foreach($calendar->datedTasks as $day => $times) : ?>
<? $daytime = strtotime($day); ?>
	
<?= PHtml::openTag('h1', array(
	'id' => PHtml::dateTimeId($daytime),
	'class' => 'agenda-date',
)); ?>
<?= PHtml::encode(Yii::app()->format->formatDate($daytime)); ?>
<?= PHtml::closeTag('h1'); ?>

<div class="menu">
	<ol>
		<li>
			<?= PHtml::link(
				'Add Task',
				array('task/create/',
					'day' => PHtml::encode(date('d', $daytime)),
					'month' => PHtml::encode(date('m', $daytime)),
					'year' => PHtml::encode(date('Y', $daytime)),
				)
			); ?>
		</li>
	</ol>
</div>

<? foreach($times as $time => $tasks): ?>
<? foreach($tasks as $task): ?>
<?= $this->renderPartial('_view', array(
	'data'=>$task, 
	'showParent'=>$showParent,
)); ?>
<? endforeach; ?>
<? endforeach; ?>
<? endforeach; ?>

<? if($calendar->hasSomedayTasks) {
	echo PHtml::openTag('h1', array('id' => 'no-start-datedTasks'));
	echo 'Someday';
	echo PHtml::closeTag('h1');
	foreach($calendar->somedayTasks as $task) {
		if(!isset($task->starts)) {
			echo $this->renderPartial('_view', array(
				'data'=>$task,
				'showParent'=>$showParent,
			));
		}
	}
}
?>