<? 
/**
 * View for individual task models
 * 
 * @param Task $data model
 * @param boolean $showParent
 */

$showParent = isset($showParent) ? $showParent : true;

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"task-" . PHtml::encode($data->id),
		'class'=>PHtml::taskClass($data),
	),
)); ?>

	<? $story->beginStoryContent(); ?>
		<? // task name ?>
		<h1>
			<? if($data->starts): ?>
			<time><?= PHtml::encode($data->formattedStartTime); ?></time>
			<? endif; ?>
			<?= PHtml::link(
				PHtml::encode($data->name), 
				array('/task/view', 'id'=>$data->id)
			); ?>
			<span class="status"><?= PHtml::encode($data->currentresponse->statusLabel); ?></span>
		</h1>
	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>