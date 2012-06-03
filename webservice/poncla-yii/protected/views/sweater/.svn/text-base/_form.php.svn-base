<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'sweater-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="field">
		<b><?php echo PHtml::encode($model->getAttributeLabel('id')); ?>:</b>
		<?php echo PHtml::encode($model->id); ?>
	</div>

	<div class="field">
		<b><?php echo PHtml::encode($model->getAttributeLabel('style')); ?>:</b>
		<?php echo PHtml::encode($model->style); ?>
	</div>

	<div class="field">
		<b><?php echo PHtml::encode($model->getAttributeLabel('clothColor')); ?>:</b>
		<?php echo PHtml::encode($model->clothColor); ?>
	</div>

	<div class="field">
		<b><?php echo PHtml::encode($model->getAttributeLabel('letterColor')); ?>:</b>
		<?php echo PHtml::encode($model->letterColor); ?>

	</div>

	<div class="field">
		<b><?php echo PHtml::encode($model->getAttributeLabel('stitchingColor')); ?>:</b>
		<?php echo PHtml::encode($model->stitchingColor); ?>
	</div>

	<div class="field">
		<b><?php echo PHtml::encode($model->getAttributeLabel('size')); ?>:</b>
		<?php echo PHtml::encode($model->size); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'available'); ?>
		<?php echo $form->checkBox($model,'available'); ?>
		<?php echo $form->error($model,'available'); ?>
	</div>

	<div class="field buttons">
		<?php echo PHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>