<? 
/**
 * Form for creating/updating tasks
 * @uses model Task model
 * @uses inline boolean should display datetimes?  Defaults to false
 * @uses index number in list of task
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

$form= $form ? $form : $this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'task-form',
	'action'=> isset($action) ? $action : '',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'class'=>$classForm,
	),
)); ?>

	<? if($index): ?>
	<h1>Step #<?= PHtml::encode($index); ?></h1>
	<? endif ?>
	
	<?= $form->errorSummary($model); ?>
	
	<div class="field">
		<?= $form->labelEx($model,"[$index]name"); ?>
		<?= $form->textField($model,"[$index]name",
			array(
				'size'=>60,
				'maxlength'=>255,
				'placeholder'=>"What's next?",
			)); ?>
		<?= $form->error($model,"[$index]name"); ?>
	</div>
	
	
	<div class="field datetime">
		<? if(!$inline):
		// preformat date before loading into widget 
		$this->widget('application.components.widgets.jui.JuiDateTimePicker', 
			array(
				'model'=>$model,
				'dateTimeAttribute'=>"[$index]starts",
				'dateAttribute'=>"[$index]startDate",
				'timeAttribute'=>"[$index]startTime",
				// additional javascript options for the date picker plugin
				'options'=>array(
					'showAnim'=>'fold',
				),
			)
		);
		endif; ?>
		<?= $form->error($model,"[$index]starts"); ?>
	</div>
	
	<? if(!$model->isNewRecord): ?>
	<div class="field buttons">
		<?= PHtml::submitButton($model->isNewRecord ? "Create" : 'Update', 
			array('name'=>'add_no_more')
		); ?>
	</div>
	<? endif; ?>

<? //$this->endWidget(); ?>