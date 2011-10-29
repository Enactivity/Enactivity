<?php
$this->pageTitle = 'Recover Password';
?>

<?php echo PHtml::beginContentHeader(); ?>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'password-recovery-form',
	'enableAjaxValidation'=>false,
)); 
?>
	<div class="field">
		<div class="formlabel"><?php echo $form->labelEx($model,'email'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'email',
			 array('placeholder'=>'@')); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'email'); ?></div>
	</div>

	<div class="field buttons">
		<?php echo PHtml::submitButton('Send me a new password'); ?>
	</div>
	
<?php $this->endWidget(); ?>