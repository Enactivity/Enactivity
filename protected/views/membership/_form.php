<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?= $form->errorSummary($model); ?>

	<div class="field">
		<div class="formlabel"><?= $form->labelEx($model,'name'); ?></div>
		<div class="forminput"><?= $form->textField($model,'name',
			array(
				'maxlength'=>Group::NAME_MAX_LENGTH, 
				'autofocus'=>'autofocus'
			)
			); ?></div>
		<div class="formerrors"><?= $form->error($model,'name'); ?></div>
	</div>

	<div class="field">
		<div class="formlabel"><?= $form->labelEx($model,'slug'); ?></div>
		<div class="forminput"><?= $form->textField($model,'slug',
			array('maxlength'=>Group::SLUG_MAX_LENGTH)
			); ?></div>
		<div class="formerrors"><?= $form->error($model,'slug'); ?></div>
	</div>
	
	<div class="field buttons">
		<?= PHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<? $this->endWidget(); ?>