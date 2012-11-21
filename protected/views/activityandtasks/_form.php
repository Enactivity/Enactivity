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

	<? if($model->activity->isNewRecord) {
		$this->widget('application.components.widgets.inputs.GroupInputRow', array(
				'form' => $form,
				'model' => $model->activity,
				'groups' => Yii::app()->user->model->groups,
		));
	} ?>

	<div class="field">
		<?= $form->labelEx($model->activity,'name'); ?>
		<?= $form->textField($model->activity,'name',array(
			'size'=>60,
			'maxlength'=>255,
			'placeholder'=>'What\'s to be done?'
		)); ?>
		<?= $form->error($model->activity,'name'); ?>
	</div>

	<div class="field">
		<?= $form->labelEx($model->activity,'description'); ?>
		<?= $form->textArea($model->activity,'description',array(
			'fields'=>6, 
			'cols'=>50,
			'placeholder'=>'More details if needed.',
		)); ?>
		<?= $form->error($model->activity,'description'); ?>
	</div>

	<? if($model->activity->isNewRecord): ?>
	<p>Now, let's add some steps for your group to participate in.</p>

	<? foreach($model->tasks as $index => $task): ?>
	<fieldset class="new-task-form">
		<? if($index): ?>
		<h1>Step #<?= PHtml::encode($index); ?></h1>
		<? endif ?>

		<div class="field">
			<?= $form->labelEx($task,"[$index]name"); ?>
			<?= $form->textField($task,"[$index]name",
				array(
					'size'=>60,
					'maxlength'=>255,
					'placeholder'=>"What's next?",
				)); ?>
			<?= $form->error($task,"[$index]name"); ?>
		</div>
	
	
		<div class="field datetime">
			<? $this->widget('application.components.widgets.jui.JuiDateTimePicker', 
				array(
					'model'=>$task,
					'dateTimeAttribute'=>"[$index]starts",
					'dateAttribute'=>"[$index]startDate",
					'timeAttribute'=>"[$index]startTime",
					// additional javascript options for the date picker plugin
					'options'=>array(
						'showAnim'=>'fold',
					),
				)
			); ?>
			<?= $form->error($task,"[$index]starts"); ?>
		</div>
	</fieldset>
	<? endforeach ?>
	<? endif; ?>

	<div class="field buttons">
		<? if($model->activity->isNewRecord): ?>
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
		<?= PHtml::submitButton($model->activity->isNewRecord ? 'Publish' : 'Update',
			array(
				'name'=>'publish',
			)
		); ?>
	</div>

<?php $this->endWidget(); ?>