<?php 
/**
 * Form for creating/updating tasks
 * @uses model Task model
 * @uses inline boolean should display datetimes?  Defaults to false
 */

// Initialize inline
// $inline = isset($inline) ? $inline : false;
$inline = false;

$classForm = 'update-task';
if($model->isNewRecord) {
	$classForm = 'new-task';
}

$classForm .= $inline ? ' inline' : '';

$form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'task-form',
	'action'=> isset($action) ? $action : '',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'class'=>$classForm,
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<?php
	// only show row when is root task
	if(!isset($model->parentId)) {
		$this->widget('application.components.widgets.inputs.GroupInputRow', array(
				'form' => $form,
				'model' => $model,
				'groups' => Yii::app()->user->model->groups,
		));
	}
	?>
	
	<div class="field">
		<?php
		echo $form->labelEx($model,'name');
		echo $form->textField($model,'name',
			array(
				'size'=>60,
				'maxlength'=>255,
				'placeholder'=>"What's next?",
			)); 
		?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	
	
	<div class="field">
		<?php if(!$inline): ?>
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
		<?php endif; ?>
		<?php echo $form->error($model,'starts'); ?>
	</div>
	
	<div class="field buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>