<?php
$this->pageTitle = 'Recover Password';

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
		<div class="formlabel"><?php echo $form->labelEx($model,'email'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'email',
			 array('placeholder'=>'Email')); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'email'); ?></div>
	</div>

	<div class="row">
		<div class="buttons"><?php echo PHtml::submitButton('Send me a new password'); ?></div>
	</div>
	
<?php $this->endWidget(); ?>
</div><!-- form -->
