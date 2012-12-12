<?
/**
 * @uses $model 
 * @uses $comment
 * @uses $commentsDataProvider
 */
$this->pageTitle = $model->name;
?>

<?= PHtml::beginContentHeader(array('class'=>PHtml::activityClass($model) )); ?>
	<div class="menu content-header-menu">
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
					array('activity/tasks', 'id'=>$model->id),
					array(
						'id'=>'tasks-create-menu-item',
						'class'=>'neutral tasks-create-menu-item',
						'title'=>'Add new tasks to this activity',
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

<section id="comments">
	<h1>Comments</h1>
	
	<? if($comments): ?>
	<? foreach($comments as $fbcomment): ?>
	<?= $this->renderPartial('/comment/_view', array(
		'data'=>$fbcomment,
	)); ?>
	<? endforeach; ?>
	<? elseif($model->isCommentable): ?>
	<p class="blurb">No one has written any comments yet, be the first!</p>
	<? else: ?>
	<p class="blurb">Sorry, comments have been disabled for this activity</p>
	<? endif; ?>
	
	<? if($model->isCommentable): ?>
	<?= $this->renderPartial('/comment/_form', array('model'=>$comment)); ?>
	<? endif; ?>
</section>