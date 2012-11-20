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

	<p>Add some details about the overall activity.</p>

	<?= $form->errorSummary($model); ?>

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

	<? if($model->isNewRecord): ?>
	<p>Now, let's add some steps for your group to participate in.</p>

	<? foreach($tasks as $index => $task): ?>
	<section class="new-task-form">
		<?= $this->renderPartial('/task/_form', array(
			'model'=>$task,
			'index'=>$index,
			'form'=>$form,
		)); ?>
	</section>
	<? endforeach ?>
	<? endif; ?>

	<div class="field buttons">
		<? if($model->isNewRecord): ?>
		<?= PHtml::submitButton('Add More Tasks', 
			array(
				'name'=>'add_more',
				'class'=>'neutral',
			)
		); ?>
		<?= PHtml::submitButton('Save as Draft', 
			array(
				'name'=>'draft',
				'class'=>'neutral',
			)
		); ?>
		<? endif; ?>
		<?= PHtml::submitButton($model->isNewRecord ? 'Publish' : 'Update',
			array(
				'name'=>'publish',
			)
		); ?>
	</div>

<?php $this->endWidget(); ?>