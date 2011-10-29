<?php
$this->pageTitle = 'Update Password';
$this->menu = MenuDefinitions::userMenu($model);
?>

<?php echo PHtml::beginContentHeader(); ?>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'update-password-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="field">
		<div class="formlabel"><?php echo $form->labelEx($model, 'password'); ?></div>
		<div class="forminput"><?php echo $form->passwordField($model, 'password', 
			array(
				'maxlength'=>User::PASSWORD_MAX_LENGTH,
				'autofocus'=>'autofocus',
			)); ?></div>
		<div class="formerrors"><?php echo $form->error($model, 'password'); ?></div>
	</div>
	
	<div class="field">
		<div class="formlabel"><?php echo $form->labelEx($model, 'confirmPassword'); ?></div>
		<div class="forminput"><?php echo $form->passwordField($model, 'confirmPassword',
			array('maxlength'=>User::PASSWORD_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?php echo $form->error($model, 'confirmPassword'); ?></div>
	</div>

	<div class="field buttons">
		<?php echo PHtml::submitButton($model->isNewRecord ? 'Create' : 'Update'); ?>
	</div>

<?php $this->endWidget(); ?>