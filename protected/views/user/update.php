<?php
$this->pageTitle = $model->fullName;
$this->menu = MenuDefinitions::userMenu($model);
?>

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'user-update-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'email'); ?></div>
		<div class="forminput"><?php echo $form->emailField($model,'email',array(
			'maxlength'=>User::EMAIL_MAX_LENGTH
		)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'email'); ?></div>
	</div>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'firstName'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'firstName',array(
			'maxlength'=>User::FIRSTNAME_MAX_LENGTH
		)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'firstName'); ?></div>
	</div>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'lastName'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'lastName',array(
			'maxlength'=>User::LASTNAME_MAX_LENGTH
		)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'lastName'); ?></div>
	</div>
	
	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'timeZone'); ?></div>
		<div class="forminput"><?php echo $form->timeZoneDropDownList($model,'timeZone'); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'timeZone'); ?></div>
	</div>

	<div class="row buttons">
		<?php echo PHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>