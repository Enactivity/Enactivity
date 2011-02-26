<?php $form=$this->beginWidget('ext.widgets.ActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="forminput"><?php echo $form->hiddenField($model, 'token', 
			array('maxlength'=>User::TOKEN_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?php echo $form->error($model, 'token'); ?></div>
	</div>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'email'); ?></div>
		<div class="forminput"><?php echo $form->emailField($model,'email',
			array('maxlength'=>User::EMAIL_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'email'); ?></div>
	</div>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'password'); ?></div>
		<div class="forminput"><?php echo $form->passwordField($model,'password',
			array('maxlength'=>User::PASSWORD_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'password'); ?></div>
	</div>
	
	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'confirmPassword'); ?></div>
		<div class="forminput"><?php echo $form->passwordField($model,'confirmPassword',
			array('maxlength'=>User::PASSWORD_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'confirmPassword'); ?></div>
	</div>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'firstName'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'firstName',
			array('maxlength'=>User::FIRSTNAME_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'firstName'); ?></div>
	</div>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'lastName'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'lastName',
			array('maxlength'=>User::LASTNAME_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'lastName'); ?></div>
	</div>

	<div class="row buttons">
		<?php echo PHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>