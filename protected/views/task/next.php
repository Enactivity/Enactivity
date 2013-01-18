<?
/**
 * Lists user's upcoming tasks
 * @uses calendar
 * @uses newTask
 */
?>

<header class="content-header">
	<nav>
		<? $this->widget('zii.widgets.CMenu', array(
			'encodeLabel'=>false,
			'items'=>MenuDefinitions::siteMenu()
		));?>
	</nav>
</header>

<section id="tasks" class="tasks content">
	<? if($calendar->itemCount > 0) : ?>
	<?= $this->renderPartial('_agenda', array(
		'calendar'=>$calendar,
		'showParent'=>true,
	)); ?>
	<? else: ?>
	<p class="no-results-message blurb">
		Groups are more fun when you're active!  Why not check out the <?= PHtml::link('calendar', array('task/calendar')); ?>
		to see what is listed or <?= PHtml::link('create a new activity', array('activity/create')); ?>?
	</p>
	<? endif; ?>	
</section>