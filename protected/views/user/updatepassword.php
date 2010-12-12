<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Admin: List User', 
		'url'=>array('index'), 
		'linkOptions'=>array('id'=>'user_index_menu_item'),
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Admin: View User', 
		'url'=>array('view', 'id'=>$model->id), 
		'linkOptions'=>array('id'=>'user_view_menu_item'),
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Admin: Manage User', 
		'url'=>array('admin'),
		'linkOptions'=>array('id'=>'user_admin_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin
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