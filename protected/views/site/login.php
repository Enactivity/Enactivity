<?php
$this->pageTitle = 'Login';
?>

<header>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
</header>

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>false,
)); 
?>
	<div class="field">
		<div class="formlabel"><?php echo $form->labelEx($model,'email'); ?></div>
		<div class="forminput"><?php echo $form->emailField($model,'email', 
			array(
				'placeholder'=>'@',
				'autofocus'=>'autofocus',
			)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'email'); ?></div>
	</div>

	<div class="field">
		<div class="formlabel"><?php echo $form->labelEx($model,'password'); ?></div>
		<div class="forminput"><?php echo $form->passwordField($model,'password', 
			array('placeholder'=>'*')); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'password'); ?></div>
	</div>

	<div class="field rememberMe">
		<div class="formlabel"><?php echo $form->labelEx($model,'rememberMe'); ?></div>
		<div class="forminput"><?php echo $form->checkBox($model,'rememberMe'); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'rememberMe'); ?></div>
	</div>

	<div class="field buttons">
		<?php echo PHtml::submitButton('Login'); ?>
	</div>
	
	<div class="field">
		<div class="formlink"><p><?php echo PHtml::link('Forgot my password', array(
			'user/recoverpassword'
		));?></p></div>
	</div>

<?php $this->endWidget(); ?>