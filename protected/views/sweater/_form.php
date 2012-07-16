<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'sweater-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?= $form->errorSummary($model); ?>

	<div class="field">
		<b><?= PHtml::encode($model->getAttributeLabel('id')); ?>:</b>
		<?= PHtml::encode($model->id); ?>
	</div>

	<div class="field">
		<b><?= PHtml::encode($model->getAttributeLabel('style')); ?>:</b>
		<?= PHtml::encode($model->style); ?>
	</div>

	<div class="field">
		<b><?= PHtml::encode($model->getAttributeLabel('clothColor')); ?>:</b>
		<?= PHtml::encode($model->clothColor); ?>
	</div>

	<div class="field">
		<b><?= PHtml::encode($model->getAttributeLabel('letterColor')); ?>:</b>
		<?= PHtml::encode($model->letterColor); ?>

	</div>

	<div class="field">
		<b><?= PHtml::encode($model->getAttributeLabel('stitchingColor')); ?>:</b>
		<?= PHtml::encode($model->stitchingColor); ?>
	</div>

	<div class="field">
		<b><?= PHtml::encode($model->getAttributeLabel('size')); ?>:</b>
		<?= PHtml::encode($model->size); ?>
	</div>

	<div class="field">
		<?= $form->labelEx($model,'available'); ?>
		<?= $form->checkBox($model,'available'); ?>
		<?= $form->error($model,'available'); ?>
	</div>

	<div class="field buttons">
		<?= PHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<? $this->endWidget(); ?>