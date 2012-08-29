<? 
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
	<? $story->beginStoryContent(); ?>
		<h1 class="story-title">
			<?= PHtml::link(PHtml::encode($data->name), 
				array('view', 'id'=>$data->id)
			); ?>
		</h1>
		<h2>
			Last updated <?= PHtml::encode($data->modifiedAsTimeAgo); ?>
		</h2>
	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>