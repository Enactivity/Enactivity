<?php
/**
 * @uses $this ActivityController
 * @var $model Activity
 * @var $form CActiveForm
 **/
?>

<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'activity-form',
	'action'=> isset($action) ? $action : '',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'class'=>$classForm,
	),
)); ?>

	<p>First, create a new activity, next we'll add some tasks that people can sign up for.</p>

	<? if($model->isNewRecord) {
		$this->widget('application.components.widgets.inputs.GroupInputRow', array(
				'form' => $form,
				'model' => $model,
				'groups' => Yii::app()->user->model->groups,
		));
	} ?>

	<div class="field">
		<?= $form->labelEx($model,'name'); ?>
		<?= $form->textField($model,'name',array(
			'size'=>60,
			'maxlength'=>255,
			'placeholder'=>'What\'s to be done?'
		)); ?>
		<?= $form->error($model,'name'); ?>
	</div>

	<div class="field">
		<?= $form->labelEx($model,'description'); ?>
		<?= $form->textArea($model,'description',array(
			'fields'=>6, 
			'cols'=>50,
			'placeholder'=>'More details if needed.',
		)); ?>
		<?= $form->error($model,'description'); ?>
	</div>

	<div class="field buttons">
		<?= CHtml::submitButton($model->isNewRecord ? 'I\'m ready to add some tasks' : 'Update'); ?>
	</div>

<?php $this->endWidget(); ?>