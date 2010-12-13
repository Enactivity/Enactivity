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

<h1>Update <?php echo $model->fullName; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-update-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

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