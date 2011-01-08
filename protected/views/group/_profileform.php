<div class="form">

<?php $form=$this->beginWidget('ext.pwidgets.PActiveForm', array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model->groupProfile, 'description'); ?></div>
		<div class="forminput"><?php echo $form->textArea($model->groupProfile, 'description', 
			array(
				'maxlength'=>GroupProfile::DESCRIPTION_MAX_LENGTH,
				'rows'=>5,
				'autofocus'=>'autofocus',
			)); 
		?></div>
		<div class="formerrors"><?php echo $form->error($model->groupProfile, 'description'); ?></div>
	</div>

	<div class="row">
		<div class="buttons"><?php echo PHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?></div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->