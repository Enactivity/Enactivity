<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

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

<h1>Update Password</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'update-password-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'password'); ?>
		<?php echo $form->passwordField($model, 'password', 
			array('maxlength'=>User::PASSWORD_MAX_LENGTH)); ?>
		<?php echo $form->error($model, 'password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'confirmPassword'); ?>
		<?php echo $form->passwordField($model, 'confirmPassword',
			array('maxlength'=>User::PASSWORD_MAX_LENGTH)); ?>
		<?php echo $form->error($model, 'confirmPassword'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->