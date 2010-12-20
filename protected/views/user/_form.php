<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model, 'token', array('maxlength'=>User::TOKEN_MAX_LENGTH)); ?>
		<?php echo $form->error($model, 'token'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'username'); ?>
		<?php echo $form->textField($model, 'username', array('maxlength'=>User::USERNAME_MAX_LENGTH)); ?>
		<?php echo $form->error($model, 'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('maxlength'=>User::EMAIL_MAX_LENGTH)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('maxlength'=>User::PASSWORD_MAX_LENGTH)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'confirmPassword'); ?>
		<?php echo $form->passwordField($model,'confirmPassword',array('maxlength'=>User::PASSWORD_MAX_LENGTH)); ?>
		<?php echo $form->error($model,'confirmPassword'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'firstName'); ?>
		<?php echo $form->textField($model,'firstName',array('maxlength'=>User::FIRSTNAME_MAX_LENGTH)); ?>
		<?php echo $form->error($model,'firstName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastName'); ?>
		<?php echo $form->textField($model,'lastName',array('maxlength'=>User::LASTNAME_MAX_LENGTH)); ?>
		<?php echo $form->error($model,'lastName'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->