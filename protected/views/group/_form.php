<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'name'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'name',
			array(
				'maxlength'=>Group::NAME_MAX_LENGTH, 
				'autofocus'=>'autofocus'
			)
			); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'name'); ?></div>
	</div>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'slug'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'slug',
			array('maxlength'=>Group::SLUG_MAX_LENGTH)
			); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'slug'); ?></div>
	</div>
	
	<div class="row buttons">
		<?php echo PHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>