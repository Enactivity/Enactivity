<?php
/**
 * @uses $this ActivityController
 * @var $model ActivityAndTasksForm
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

	<?= $form->errorSummary($model->models); ?>

	<fieldset class="new-activity-form">
		<div class="field">
			<?= $form->labelEx($model->activity,'name'); ?>
			<?= $form->textField($model->activity,'name',array(
				'size'=>60,
				'maxlength'=>255,
				'placeholder'=>'Provide a brief title'
			)); ?>
			<?= $form->error($model->activity,'name'); ?>
		</div>

		<div class="field">
			<?= $form->labelEx($model->activity,'description'); ?>
			<?= $form->textArea($model->activity,'description',array(
				'fields'=>6, 
				'cols'=>50,
				'placeholder'=>'Describe the activity in depth here.',
			)); ?>
			<?= $form->error($model->activity,'description'); ?>
		</div>

		<? if($model->activity->isNewRecord) {
			$this->widget('application.components.widgets.inputs.GroupInputRow', array(
					'form' => $form,
					'model' => $model->activity,
					'groups' => Yii::app()->user->model->groups,
			));
		} ?>
	</fieldset>

	<h2>Tasks</h2>

	<? if($model->activity->isNewRecord): ?>
	<p>Now, let's add some tasks for your group to participate in.</p>
	<? endif; ?>

	<? foreach($model->tasks as $index => $task): ?>
	<fieldset class="task-form">

		<div class="field">
			<?= $form->labelEx($task,"[$index]name"); ?>
			<?= $form->textField($task,"[$index]name",
				array(
					'size'=>60,
					'maxlength'=>255,
					'placeholder'=>"Describe an action to participate in",
				)); ?>
			<?= $form->error($task,"[$index]name"); ?>
		</div>
	
		<div class="field datetime">
			<?= $form->labelEx($task,"[$index]starts"); ?>
			<?= $form->dateField($task,"[$index]startDate",
				array(
					'size'=>60,
					'maxlength'=>255,
				)); ?>
			<?= $form->timeDropDownList($task,"[$index]startTime",array()); ?>
			<?= $form->error($task,"[$index]starts"); ?>
			<?= $form->error($task,"[$index]startDate"); ?>
			<?= $form->error($task,"[$index]startTime"); ?>
		</div>
	</fieldset>
	<? endforeach ?>

	<div class="field buttons">
		<?= PHtml::submitButton('Add More Tasks', 
			array(
				'name'=>'add_more',
				'class'=>'neutral',
			)
		); ?>
		<?= PHtml::submitButton($model->activity->isNewRecord ? 'Publish' : 'Update',
			array(
				'name'=>'publish',
			)
		); ?>
	</div>

<?php $this->endWidget(); ?>