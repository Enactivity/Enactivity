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

	<? if($model->isNewRecord) {
		$this->widget('application.components.widgets.inputs.GroupInputRow', array(
				'form' => $form,
				'model' => $model,
				'groups' => Yii::app()->user->model->groups,
		));
	} ?>

	<div class="field">
		<?= $form->labelEx($model,'name'); ?>
		<?= $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?= $form->error($model,'name'); ?>
	</div>

	<div class="field">
		<?= $form->labelEx($model,'description'); ?>
		<?= $form->textArea($model,'description',array('fields'=>6, 'cols'=>50)); ?>
		<?= $form->error($model,'description'); ?>
	</div>

	<div class="field buttons">
		<?= CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>