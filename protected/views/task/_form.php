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
	<div class="field">
		<?php
		if(!$model->isNewRecord) { 
			echo $form->labelEx($model,'name');
		} 
		?>
		<?php echo $form->textField($model,'name',
			array(
				'size'=>60,
				'maxlength'=>255,
				'placeholder'=>"What's next?",
			)); 
		?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	
	<?php if(!$model->isNewRecord): ?>
	<div class="field">
		<?php echo $form->labelEx($model,'starts'); ?>
		<div class="forminput"><?php
			// preformat date before loading into widget 
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
	<?php endif; ?>
	<div class="field buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>