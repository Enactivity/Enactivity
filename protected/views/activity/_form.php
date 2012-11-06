<?php
/* @var $this ActivityController */
/* @var $model Activity */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'activity-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'groupId'); ?>
		<?php echo $form->textField($model,'groupId',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'groupId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'authorId'); ?>
		<?php echo $form->textField($model,'authorId',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'authorId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'facebookId'); ?>
		<?php echo $form->textField($model,'facebookId',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'facebookId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'participantsCount'); ?>
		<?php echo $form->textField($model,'participantsCount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'participantsCount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'participantsCompletedCount'); ?>
		<?php echo $form->textField($model,'participantsCompletedCount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'participantsCompletedCount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified'); ?>
		<?php echo $form->textField($model,'modified'); ?>
		<?php echo $form->error($model,'modified'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->