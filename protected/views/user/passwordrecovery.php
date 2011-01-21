<?php
$this->pageTitle = 'Recover Password';

$this->menu = MenuDefinitions::userMenu();
?>

<div class="form">
<?php $form=$this->beginWidget('ext.widgets.ActiveForm', array(
	'id'=>'password-recovery-form',
	'enableAjaxValidation'=>false,
)); 
?>
	<div class="row">
		<p>Please fill out the following form with your login credentials:</p>
	</div>
	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'usernameOrEmail'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'usernameOrEmail',
			 array('placeholder'=>'Email or username')); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'usernameOrEmail'); ?></div>
	</div>

	<div class="row">
		<div class="buttons"><?php echo PHtml::submitButton('Send me a new password'); ?></div>
	</div>
	
<?php $this->endWidget(); ?>
</div><!-- form -->
