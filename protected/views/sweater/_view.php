<? 

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"sweater-" . PHtml::encode($data->id),
		'class'=>PHtml::sweaterClass($data),
	),
)); ?>

	<? $story->beginStoryContent(); ?>

		<b><?= CHtml::encode($data->getAttributeLabel('style')); ?>:</b>
		<?= CHtml::encode($data->style); ?>
		<br />

		<b><?= CHtml::encode($data->getAttributeLabel('clothColor')); ?>:</b>
		<?= CHtml::encode($data->clothColor); ?>
		<br />

		<b><?= CHtml::encode($data->getAttributeLabel('letterColor')); ?>:</b>
		<?= CHtml::encode($data->letterColor); ?>
		<br />

		<b><?= CHtml::encode($data->getAttributeLabel('stitchingColor')); ?>:</b>
		<?= CHtml::encode($data->stitchingColor); ?>
		<br />

		<b><?= CHtml::encode($data->getAttributeLabel('size')); ?>:</b>
		<?= CHtml::encode($data->size); ?>
		<br />

	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>