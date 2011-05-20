<?php
$this->pageTitle = 'Login';
?>

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>false,
)); 
?>
	<div class="row">
		<p>Please fill out the following form with your login credentials:</p>
	</div>
	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'email'); ?></div>
		<div class="forminput"><?php echo $form->emailField($model,'email', 
			array(
				'placeholder'=>'Email',
				'autofocus'=>'autofocus',
			)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'email'); ?></div>
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

	<div class="row buttons">
		<?php echo PHtml::submitButton('Login'); ?>
	</div>
	
	<div class="row">
		<div class="formlink"><?php echo PHtml::link('Forgot my password', array(
			'user/recoverpassword'
		));?></div>
	</div>

<?php $this->endWidget(); ?>