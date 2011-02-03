<div class="form">

<?php $form=$this->beginWidget('ext.widgets.ActiveForm', array(
	'id'=>'event-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php 
	if($model->isNewRecord) { 
		$this->widget('ext.widgets.inputs.GroupInputRow', array(
			'form' => $form,
			'model' => $model,
			'groups' => Yii::app()->user->model->groups,
		));
	}
	?>
	
	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'starts'); ?></div>
		<div class="forminput"><?php
			// preformat date before loading into widget 
			$model->starts = isset($model->starts) ? date('m/d/Y g:i a', strtotime($model->starts)) : null;
			$this->widget('ext.widgets.jui.JuiDateTimePicker', 
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
		<div class="formerrors"><?php echo $form->error($model,'starts'); ?></div>
	</div>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'ends'); ?></div>
		<div class="forminput"><?php 
			// preformat date before loading into widget 
			$model->ends = isset($model->ends) ? date('m/d/Y g:i a', strtotime($model->ends)) : null;
			$this->widget('ext.widgets.jui.JuiDateTimePicker', 
				array(
				    'model'=>$model,
				    'dateAttribute'=>'endDate',
					'timeAttribute'=>'endTime',
					'options'=>array(
						'ampm' => true,
						'minDate' => 0,
				        'timeFormat' => 'h:mm tt',
					),
				)
			);  
		?></div>
		<div class="formerrors"><?php echo $form->error($model,'ends'); ?></div>
	</div>	
	
	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'name'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'name',
			array('maxlength'=>Event::NAME_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'name'); ?></div>
	</div>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'location'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'location',
			array('maxlength'=>Event::LOCATION_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'location'); ?></div>
	</div>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'description'); ?></div>
		<div class="forminput"><?php echo $form->textArea($model,'description',
			array(
				'maxlength'=>Event::DESCRIPTION_MAX_LENGTH,
				'rows'=>5,
			)); 
		?></div>
		<div class="formerrors"><?php echo $form->error($model,'description'); ?></div>
	</div>

	<div class="row">
		<div class="buttons"><?php echo PHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?></div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->