<?php
$this->pageTitle = 'Update Password';
$this->menu = MenuDefinitions::userMenu($model);
?>

<div class="form">

<?php $form=$this->beginWidget('ext.pwidgets.PActiveForm', array(
	'id'=>'update-password-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model, 'password'); ?></div>
		<div class="forminput"><?php echo $form->passwordField($model, 'password', 
			array(
				'maxlength'=>User::PASSWORD_MAX_LENGTH,
				'autofocus'=>'autofocus',
			)); ?></div>
		<div class="formerrors"><?php echo $form->error($model, 'password'); ?></div>
	</div>
	
	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model, 'confirmPassword'); ?></div>
		<div class="forminput"><?php echo $form->passwordField($model, 'confirmPassword',
			array('maxlength'=>User::PASSWORD_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?php echo $form->error($model, 'confirmPassword'); ?></div>
	</div>

	<div class="row">
		<div class="buttons"><?php echo PHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?></div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->