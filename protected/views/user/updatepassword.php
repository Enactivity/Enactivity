<?php
$this->pageTitle = 'Update Password';
$this->menu=array(
	array('label'=>'Update Profile', 
		'url'=>array('update', 'id'=>$model->id),
		'linkOptions'=>array('id'=>'user_update_menu_item'), 
		'visible'=>Yii::app()->user->id == $model->id,
	),
	array('label'=>'Update Password', 
		'url'=>array('updatepassword', 'id'=>$model->id),
		'linkOptions'=>array('id'=>'user_update_menu_item'), 
		'visible'=>Yii::app()->user->id == $model->id,
	),
);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'update-password-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model, 'password'); ?></div>
		<div class="forminput"><?php echo $form->passwordField($model, 'password', 
			array(
				'maxlength'=>User::PASSWORD_MAX_LENGTH,
				'autofocus'=>'autofocus',
			)); ?></div>
		<div class="formerrors"><?php echo $form->error($model, 'password'); ?></div>
	</div>
	
	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model, 'confirmPassword'); ?></div>
		<div class="forminput"><?php echo $form->passwordField($model, 'confirmPassword',
			array('maxlength'=>User::PASSWORD_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?php echo $form->error($model, 'confirmPassword'); ?></div>
	</div>

	<div class="row">
		<div class="buttons"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?></div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->