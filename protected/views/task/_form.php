<?php 

$classForm = 'update-task';
if($model->isNewRecord) {
	$classForm = 'new-task';
}

$form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'task-form',
	'action'=> isset($action) ? $action : '',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'class'=>$classForm,
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',
			array(
				'size'=>60,
				'maxlength'=>255,
				'placeholder'=>PHtml::encode("i.e. be the change we want to see in the world"),
			)); 
		?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	
	<?php if(!$model->isNewRecord): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'starts'); ?>
		<div class="forminput"><?php
			// preformat date before loading into widget 
			$model->starts = isset($model->starts) ? date('m/d/Y g:i a', strtotime($model->starts)) : null;
			$this->widget('application.components.widgets.jui.JuiDateTimePicker', 
				array(
					'model'=>$model,
					'dateAttribute'=>'startDate',
					'timeAttribute'=>'startTime',
					// additional javascript options for the date picker plugin
					'options'=>array(
						'showAnim'=>'fold',
						'minDate' => 0,
					),
				)
			);
		?></div>
		<?php echo $form->error($model,'starts'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ends'); ?>
		<div class="forminput"><?php
			// preformat date before loading into widget 
			$model->starts = isset($model->starts) ? date('m/d/Y g:i a', strtotime($model->starts)) : null;
			$this->widget('application.components.widgets.jui.JuiDateTimePicker', 
				array(
					'model'=>$model,
					'dateAttribute'=>'endDate',
					'timeAttribute'=>'endTime',
					// additional javascript options for the date picker plugin
					'options'=>array(
						'showAnim'=>'fold',
						'minDate' => 0,
					),
				)
			);
		?></div>
		<?php echo $form->error($model,'ends'); ?>
	</div>
	<?php endif; ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>