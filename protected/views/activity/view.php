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
			<? if($model->isDraft): ?>
			<li>
				<?= PHtml::button(
					"Publish", 
					array( //html
						'submit'=>array('activity/publish', 'id'=>$model->id),
						'csrf'=>true,
						'id'=>'activity-publish-menu-item-' . $model->id,
						'class'=>'positive activity-publish-menu-item',
						'title'=>'Show this activity to the rest of the team',
					)
				); ?>
			</li>
			<? endif; ?>

			<li>
				<?= PHtml::link(
					'<i></i> Add tasks', 
					array('task/create', 'activityId'=>$model->id),
					array(
						'id'=>'task-create-menu-item',
						'class'=>'neutral task-create-menu-item',
						'title'=>'Add a new task to this activity',
					)
				); ?>
			</li>
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

	<? if($model->description): ?>
	<div id="details">
		<?= Yii::app()->format->formatStyledText($model->description); ?>
	</div>
	<? endif; ?>
<?= PHtml::endContentHeader(); ?>

<section id="tasks" class="tasks agenda">
	<?= $this->renderPartial('_tasks', array(
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