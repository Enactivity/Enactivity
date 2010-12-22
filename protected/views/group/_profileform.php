<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model->groupProfile, 'description'); ?>
		<?php echo $form->textArea($model->groupProfile, 'description', 
			array(
				'maxlength'=>GroupProfile::DESCRIPTION_MAX_LENGTH,
				'rows'=>5,
			)); 
		?>
		<?php echo $form->error($model->groupProfile, 'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->