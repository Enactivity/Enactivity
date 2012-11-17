<? 
/**
 * View for individual group models
 * 
 * @uses membership $data model
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"group-" . PHtml::encode($data->group->id),
		'class'=>PHtml::groupClass($data->group),
	),
));?>
	<? $story->beginStoryContent(); ?>
		<h1 class="story-title">
			<?= PHtml::link(PHtml::encode($data->group->name), 
				array('view', 'id'=>$data->group->id)
			); ?>
		</h1>
		<h2><?= $data->status; ?><h2>
	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>