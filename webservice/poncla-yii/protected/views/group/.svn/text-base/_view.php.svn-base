<?php 
/**
 * View for individual group models
 * 
 * @uses Group $data model
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"group-" . PHtml::encode($data->id),
		'class'=>PHtml::groupClass($data),
	),
));?>
	<?php $story->beginStoryContent(); ?>
		<h1 class="story-title">
			<?php echo PHtml::link(PHtml::encode($data->name), 
				array('view', 'id'=>$data->id)
			); ?>
		</h1>
	<?php $story->endStoryContent(); ?>
<?php $this->endWidget(); ?>