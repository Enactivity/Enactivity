<?php
$this->pageTitle = 'Login';
?>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>false,
)); 
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'usernameOrEmail'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'usernameOrEmail', 
			array(
				'placeholder'=>'Email or username',
				'autofocus'=>'autofocus',
			)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'usernameOrEmail'); ?></div>
	</div>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'password'); ?></div>
		<div class="forminput"><?php echo $form->passwordField($model,'password', 
			array('placeholder'=>'Password')); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'password'); ?></div>
	</div>

	<div class="row rememberMe">
		<div class="formlabel"><?php echo $form->labelEx($model,'rememberMe'); ?></div>
		<div class="forminput"><?php echo $form->checkBox($model,'rememberMe'); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'rememberMe'); ?></div>
	</div>

	<div class="row">
		<div class="buttons"><?php echo PHtml::submitButton('Login'); ?></div>
	</div>
	
	<div class="row">
		<div class="formlink"><?php echo PHtml::link('Forgot my password', array(
			'user/recoverpassword'
		));?></div>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
