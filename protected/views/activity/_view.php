<?php
/* @var $this ActivityController */
/* @var $model Activity */
?>

<? $story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"activity-" . PHtml::encode($data->id),
		'class'=>PHtml::activityClass($data),
	),
)); ?>

	<? $story->beginStoryContent(); ?>
	<h1>
		<?= PHtml::link(
			PHtml::encode($data->name), 
			array('/activity/view', 'id'=>$data->id)
		); ?>
	</h1>

	<? if($data->description): ?>
	<p><?= PHtml::encode($data->description); ?></p>
	<? endif; ?>

	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>