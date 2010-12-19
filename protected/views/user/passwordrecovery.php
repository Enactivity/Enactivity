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
		<?php echo $form->labelEx($model,'usernameOrEmail'); ?>
		<?php echo $form->textField($model,'usernameOrEmail', array('placeholder'=>'Email or username')); ?>
		<?php echo $form->error($model,'usernameOrEmail'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>
	
<?php $this->endWidget(); ?>
</div><!-- form -->
