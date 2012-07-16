<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?= $form->errorSummary($model); ?>

	<div class="field">
		<div class="forminput"><?= $form->hiddenField($model, 'token', 
			array('maxlength'=>User::TOKEN_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?= $form->error($model, 'token'); ?></div>
	</div>

	<div class="field">
		<div class="formlabel"><?= $form->labelEx($model,'email'); ?></div>
		<div class="forminput"><?= $form->emailField($model,'email',
			array('maxlength'=>User::EMAIL_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?= $form->error($model,'email'); ?></div>
	</div>

	<div class="field">
		<div class="formlabel"><?= $form->labelEx($model,'password'); ?></div>
		<div class="forminput"><?= $form->passwordField($model,'password',
			array('maxlength'=>User::PASSWORD_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?= $form->error($model,'password'); ?></div>
	</div>
	
	<div class="field">
		<div class="formlabel"><?= $form->labelEx($model,'confirmPassword'); ?></div>
		<div class="forminput"><?= $form->passwordField($model,'confirmPassword',
			array('maxlength'=>User::PASSWORD_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?= $form->error($model,'confirmPassword'); ?></div>
	</div>

	<div class="field">
		<div class="formlabel"><?= $form->labelEx($model,'firstName'); ?></div>
		<div class="forminput"><?= $form->textField($model,'firstName',
			array('maxlength'=>User::FIRSTNAME_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?= $form->error($model,'firstName'); ?></div>
	</div>

	<div class="field">
		<div class="formlabel"><?= $form->labelEx($model,'lastName'); ?></div>
		<div class="forminput"><?= $form->textField($model,'lastName',
			array('maxlength'=>User::LASTNAME_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?= $form->error($model,'lastName'); ?></div>
	</div>

	<div class="field">
		<div class="formlabel"><?= $form->labelEx($model,'timeZone'); ?></div>
		<div class="forminput"><?= $form->timeZoneDropDownList($model,'timeZone'); ?></div>
		<div class="formerrors"><?= $form->error($model,'timeZone'); ?></div>
	</div>

	<div class="field buttons">
		<?= PHtml::submitButton($model->isNewRecord ? 'Create' : 'Update'); ?>
	</div>

<? $this->endWidget(); ?>