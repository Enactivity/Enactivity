<? 
/**
 * Form for creating/updating tasks
 * @uses model Task model
 * @uses inline boolean should display datetimes?  Defaults to false
 * @uses action string action to submit form
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

	<?= $form->errorSummary($model); ?>
	
	<?
	// only show row when is root task
	if($model->isNewRecord) {
		$this->widget('application.components.widgets.inputs.GroupInputRow', array(
				'form' => $form,
				'model' => $model,
				'groups' => Yii::app()->user->model->groups,
		));
	}
	?>
	
	<div class="field">
		<?
		echo $form->labelEx($model,'name');
		echo $form->textField($model,'name',
			array(
				'size'=>60,
				'maxlength'=>255,
				'placeholder'=>"What's next?",
			)); 
		?>
		<?= $form->error($model,'name'); ?>
	</div>
	
	
	<div class="field datetime">
		<? if(!$inline):
		// preformat date before loading into widget 
		$this->widget('application.components.widgets.jui.JuiDateTimePicker', 
			array(
				'model'=>$model,
				'dateTimeAttribute'=>'starts',
				'dateAttribute'=>'startDate',
				'timeAttribute'=>'startTime',
				// additional javascript options for the date picker plugin
				'options'=>array(
					'showAnim'=>'fold',
					'minDate' => 0,
				),
			)
		);
		endif; ?>
		<?= $form->error($model,'starts'); ?>
	</div>
	
	<div class="field buttons">
		<?= CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<? $this->endWidget(); ?>