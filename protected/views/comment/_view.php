<?php 
/**
 * View for individual comments
 * @uses $data Comment model
 */
?>

<article
	id="comment-<?php echo PHtml::encode($data->id); ?>"
	class="view story <?php echo PHtml::commentClass($data); ?>"
>
	<div class="story-avatar">
		<span class="creator">
		<?php //author 
			$this->widget('application.components.widgets.UserLink', array(
			'userModel' => $data->creator,
		));  ?>
		</span>
	</div>

	<div class="story-info">
		<?php // posted time ?>
		<span><?php echo PHtml::encode(Yii::app()->format->formatDateTime(strtotime($data->created))); ?></span>
	</div>
	
	<div class="story-details">
	<?php echo Yii::app()->format->formatStyledText($data->content); ?>
	</div>

</article>