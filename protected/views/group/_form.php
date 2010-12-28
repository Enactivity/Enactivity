<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

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
	
	<div class="row">
		<div class="buttons"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?></div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->