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

	<fieldset>
	
		<div class="field">
			<?= $form->labelEx($model,'name'); ?>
			<?= $form->textField($model,'name',
				array(
					'size'=>60,
					'maxlength'=>255,
					'placeholder'=>"What's a specific step for your group to do?",
				)); ?>
			<?= $form->error($model,'name'); ?>
		</div>
		
		
		<div class="field datetime">
			<?= $form->labelEx($model,"starts"); ?>
			<?= $form->dateField($model,"startDate",
				array(
					'size'=>60,
					'maxlength'=>255,
				)); ?>
			<?= $form->timeDropDownList($model,"startTime",array()); ?>
			<?= PHtml::link("<i></i> <span>Remove</span>",null,
				array(
					'class' => 'clear-field clear-date-time neutral',
					'data-type' => 'clear-button',
				)); ?>
			<?= $form->error($model,'starts'); ?>
			<?= $form->error($model,'startDate'); ?>
			<?= $form->error($model,'startTime'); ?>
		</div>
		
	</fieldset>

	<div class="field buttons">
		<? if($model->isTrashable): ?>
		<?= PHtml::button(
			PHtml::encode('Trash'), array( //html
				'submit'=>array('task/trash', 'id'=>$model->id),
				'csrf'=>true,
				'id'=>'task-trash-menu-item-' . $model->id,
				'class'=>'neutral task-trash-menu-item',
				'title'=>'Trash this task',
			)
		); ?>
		<? endif; ?>
		<? if($model->isUntrashable): ?>
		<?= PHtml::button(
			PHtml::encode('Restore'), array( //html
				'submit'=>array('task/untrash', 'id'=>$model->id),
				'csrf'=>true,
				'id'=>'task-untrash-menu-item-' . $model->id,
				'class'=>'positive task-untrash-menu-item',
				'title'=>'Restore this task',
			)
		); ?>
		<? endif; ?>
		<?= PHtml::submitButton($model->isNewRecord ? "Create" : 'Update', 
			array('name'=>'add_no_more')
		); ?>
	</div>

<? $this->endWidget(); ?>