<?
/**
 * Lists user's upcoming tasks
 * @uses calendar
 * @uses newTask
 */
?>

<header class="content-header">
	<nav>
		<ul>
			<li>
				<?= PHtml::link(
					PHtml::encode('Timeline'), 
					array('feed/index'),
					array(
						'id'=>'feed-index-menu-item',
						'class'=>'neutral feed-index-menu-item',
						'title'=>'View recent history in your group',
					)
				);
				?>
			</li>
			<? if($draftsCount): ?>
			<li>
				<?= PHtml::link(
					'Drafts <span class="draft-count">(' . PHtml::encode($draftsCount) . ')</span>', 
					array('activity/drafts'),
					array(
						'id'=>'activity-drafts-menu-item',
						'class'=>'neutral activity-drafts-menu-item',
						'title'=>'View your activities that have yet to be published',
					)
				);
				?>
			</li>
			<? endif; ?>
		</ul>
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