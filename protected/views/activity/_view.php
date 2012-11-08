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

	<b><?= PHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?= PHtml::link(PHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?= PHtml::encode($data->getAttributeLabel('groupId')); ?>:</b>
	<?= PHtml::encode($data->groupId); ?>
	<br />

	<b><?= PHtml::encode($data->getAttributeLabel('authorId')); ?>:</b>
	<?= PHtml::encode($data->authorId); ?>
	<br />

	<b><?= PHtml::encode($data->getAttributeLabel('facebookId')); ?>:</b>
	<?= PHtml::encode($data->facebookId); ?>
	<br />

	<b><?= PHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?= PHtml::encode($data->name); ?>
	<br />

	<b><?= PHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?= PHtml::encode($data->description); ?>
	<br />

	<b><?= PHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?= PHtml::encode($data->status); ?>
	<br />

	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>