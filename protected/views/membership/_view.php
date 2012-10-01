<? 
/**
 * View for individual group models
 * 
 * @uses GroupUser $data model
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"membership-" . PHtml::encode($data->group->id),
		'class'=>PHtml::groupClass($data->group),
	),
));?>
	<? $story->beginStoryContent(); ?>
		<h1 class="story-title">
			<?= PHtml::link(PHtml::encode($data->group->name), 
				array('group/view', 'id'=>$data->group->id)
			); ?>
		</h1>
		<? if($data->isActive): ?>
		Click to deactivate
		<? else: ?>
		Click to Activate
		<? endif; ?>

	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>