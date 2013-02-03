<?
/**
 * Lists tasks with no start time
 * @uses calendar
 */
?>
<section class="tasks content">
	<? if($calendar->itemCount > 0): ?> 
	<?= $this->renderPartial('/task/_agenda', array(
		'calendar'=>$calendar,
		'showParent'=>true,
	)); ?>
	<? else: ?> 
	<p class="no-results-message blurb">
		Nothing here.  Why not check out your <?= PHtml::link('calendar', array('my/calendar')); ?>
		to see what is listed or <?= PHtml::link('create a new task', array('activity/create')); ?>
		?
	</p>
	<? endif; ?>	
</section>