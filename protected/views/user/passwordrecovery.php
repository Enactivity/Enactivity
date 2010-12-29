<?php
$this->pageTitle = 'Recover Password';
?>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'password-recovery-form',
	'enableAjaxValidation'=>true,
)); 
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'usernameOrEmail'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'usernameOrEmail',
			 array('placeholder'=>'Email or username')); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'usernameOrEmail'); ?></div>
	</div>

	<div class="row">
		<div class="buttons"><?php echo PHtml::submitButton('Generate new password'); ?></div>
	</div>
	
<?php $this->endWidget(); ?>
</div><!-- form -->
