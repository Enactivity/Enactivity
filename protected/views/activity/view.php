<?
/**
 * @uses $model 
 * @uses $comment
 * @uses $commentsDataProvider
 */
$this->pageTitle = $model->name;
?>

<?= PHtml::beginContentHeader(array('class'=>PHtml::activityClass($model) )); ?>
	<h1><?= PHtml::encode($this->pageTitle); ?></h1>
	<div class="menu toolbox">
		<ul>
			<li>
				<?=
				PHtml::link(
					PHtml::encode('Edit'), 
					array('activity/update', 'id'=>$model->id),
					array(
						'id'=>'activity-update-menu-item-' . $model->id,
						'class'=>'neutral activity-update-menu-item',
						'title'=>'Edit this activity',
					)
				);
				?>
			</li>
			<li>
				<?=
				PHtml::link(
					PHtml::encode('Timeline'), 
					array('activity/feed', 'id'=>$model->id),
					array(
						'id'=>'activity-feed-menu-item',
						'class'=>'neutral activity-feed-menu-item',
						'title'=>'View recent history of this activity',
					)
				);
				?>
			</li>
		</ul>
	</div>
<?= PHtml::endContentHeader(); ?>

<section id="tasks">
	<h1><?= PHtml::encode($calendar->taskCount); ?> Tasks</h1>
	<?= $this->renderPartial('/task/_agenda', array(
		'calendar'=>$calendar,
	)); ?>
</section>

<? // show comments ?>
<section id="comments">
	<h1><?= 'Comments'; ?></h1>
	
	<?
	if($commentsDataProvider->totalItemCount > 0) :
		// show list of comments
		$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$commentsDataProvider,
			'itemView'=>'/comment/_view',
			'emptyText'=>''
		)); 
	else: ?>
	<p class="blurb">No one has written any comments yet, be the first!</p>
	<? endif; ?>
	
	
	<? // show new comment form ?>
	<?= $this->renderPartial('/comment/_form', array('model'=>$comment)); ?>
</section>