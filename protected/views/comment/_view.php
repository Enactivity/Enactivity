<? 
/**
 * View for individual comments
 * @uses $data Comment model
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"comment-" . PHtml::encode($data->id),
		'class'=>PHtml::commentClass($data),
),
));?>
	<? $story->beginAvatar(); ?>
		<span class="creator">
			<? //author 
				$this->widget('application.components.widgets.UserLink', array(
				'userModel' => $data->creator,
			));  ?>
		</span>
		@
		<? if(isset($model)) : ?>
		<span class="created">
			<?= PHtml::encode(Yii::app()->format->formatDateTimeAsAgo(strtotime($data->created))); ?></span>
			<? else: ?>
			<?= PHtml::link(
				PHtml::encode(Yii::app()->format->formatDateTimeAsAgo(strtotime($data->created))),
				array(Yii::app()->request->pathInfo, 
					'#' => 'comment-' . $data->id,
				)
			); ?>
		</span>
		<? endif; ?>
	<? $story->endAvatar(); ?>
	<? $story->beginStoryContent(); ?>

		<div class="story-details">
			<?= Yii::app()->format->formatStyledText($data->content); ?>
		</div>
	
	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>