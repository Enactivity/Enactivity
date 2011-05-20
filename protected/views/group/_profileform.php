<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model->groupProfile, 'description'); ?></div>
		<div class="forminput"><?php echo $form->textArea($model->groupProfile, 'description', 
			array(
				'maxlength'=>GroupProfile::DESCRIPTION_MAX_LENGTH,
				'autofocus'=>'autofocus',
			)); 
		?></div>
		<div class="formerrors"><?php echo $form->error($model->groupProfile, 'description'); ?></div>
	</div>

	<div class="row buttons">
		<?php echo PHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>