<?php 

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"sweater-" . PHtml::encode($data->id),
		'class'=>PHtml::sweaterClass($data),
	),
)); ?>

	<?php $story->beginStoryContent(); ?>

		<b><?php echo CHtml::encode($data->getAttributeLabel('style')); ?>:</b>
		<?php echo CHtml::encode($data->style); ?>
		<br />

		<b><?php echo CHtml::encode($data->getAttributeLabel('clothColor')); ?>:</b>
		<?php echo CHtml::encode($data->clothColor); ?>
		<br />

		<b><?php echo CHtml::encode($data->getAttributeLabel('letterColor')); ?>:</b>
		<?php echo CHtml::encode($data->letterColor); ?>
		<br />

		<b><?php echo CHtml::encode($data->getAttributeLabel('stitchingColor')); ?>:</b>
		<?php echo CHtml::encode($data->stitchingColor); ?>
		<br />

		<b><?php echo CHtml::encode($data->getAttributeLabel('size')); ?>:</b>
		<?php echo CHtml::encode($data->size); ?>
		<br />

	<?php $story->endStoryContent(); ?>
<?php $this->endWidget(); ?>