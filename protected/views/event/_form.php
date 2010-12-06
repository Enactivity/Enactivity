<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'event-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>Event::NAME_MAX_LENGTH)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('size'=>50,'maxlength'=>Event::DESCRIPTION_MAX_LENGTH)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'groupId'); ?>
		<?php echo $form->dropDownList($model,'groupId', CHtml::listData(Yii::app()->user->model->groups, 'id', 'name')); ?>
		<?php echo $form->error($model,'groupId'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'starts'); ?>
		<?php
			// preformat date before loading into widget 
			$model->starts = isset($model->starts) ? date('m/d/Y g:i a', strtotime($model->starts)) : null;
			$this->widget('application.extensions.timepicker.EJuiDateTimePicker',
				array(
				    'model'=>$model,
				    'attribute'=>'starts',
					'options'=>array(
						'ampm' => true,
						'minDate' => 0,
				        'timeFormat' => 'h:mm tt',
					),
				)
			);  
		?>
		<?php echo $form->error($model,'starts'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ends'); ?>
		<?php 
			// preformat date before loading into widget 
			$model->ends = isset($model->ends) ? date('m/d/Y g:i a', strtotime($model->ends)) : null;
			$this->widget('application.extensions.timepicker.EJuiDateTimePicker',
				array(
				    'model'=>$model,
				    'attribute'=>'ends',
					'options'=>array(
						'ampm' => true,
						'minDate' => 0,
				        'timeFormat' => 'h:mm tt',
					),
				)
			);  
		?>
		<?php echo $form->error($model,'ends'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>50,'maxlength'=>Event::LOCATION_MAX_LENGTH)); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->