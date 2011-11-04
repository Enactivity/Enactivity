<?php 
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
	<?php $story->beginAvatar(); ?>
		<span class="creator">
			<?php //author 
				$this->widget('application.components.widgets.UserLink', array(
				'userModel' => $data->creator,
			));  ?>
		</span>
	<?php $story->endAvatar(); ?>
	<?php $story->beginStoryContent(); ?>

	
			<div class="story-details">
				<?php echo Yii::app()->format->formatStyledText($data->content); ?>
			</div>
	
		<?php $story->beginControls() ?>
		<li>
			<span><?php echo PHtml::encode(Yii::app()->format->formatDateTime(strtotime($data->created))); ?></span>
		</li>
		<?php $story->endControls() ?>
	<?php $story->endStoryContent(); ?>
<?php $this->endWidget(); ?>