<?php 
$this->breadcrumbs=array(
	'Groups'=>array('Invite'),
	'Invite',
);
?>
<h1>Invite Users</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-user-invite-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'groupId'); ?>	
		<?php echo $form->dropDownList($model,'groupId', CHtml::listData(Yii::app()->user->model->groups, 'id', 'name')); ?>
		<?php echo $form->error($model,'groupId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx(User::model(),'email'); ?>
		<?php echo $form->textField(User::model(),'email'); ?>
		<?php //echo $form->dropDownList(User::model(),'email', CHtml::listData(User::model()->findAll(), 'id', 'email')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->