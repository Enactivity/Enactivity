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
			<?= $form->error($model,'starts'); ?>
			<?= $form->error($model,'startDate'); ?>
			<?= $form->error($model,'startTime'); ?>
		</div>
		
	</fieldset>

	<div class="field buttons">
		<? if($model->isTrashable): ?>
		<?= PHtml::htmlButton("Trash", array( //html
				'data-ajax-url'=>$model->trashUrl,
				'data-csrf-token'=>Yii::app()->request->csrfToken,
				'id'=>'task-trash-menu-item-' . $model->id,
				'name'=>'task-trash-menu-item-' . $model->id,
				'class'=>'neutral task-trash-menu-item',
				'title'=>'Trash this task',
			)
		); ?>
		<? endif; ?>
		<? if($model->isUntrashable): ?>
		<?= PHtml::htmlButton("Restore", array( //html
				'data-ajax-url'=>$model->untrashUrl,
				'data-csrf-token'=>Yii::app()->request->csrfToken,
				'id'=>'task-untrash-menu-item-' . $model->id,
				'name'=>'task-untrash-menu-item-' . $model->id,
				'class'=>'neutral task-untrash-menu-item',
				'title'=>'Restore this task',
			)
		); ?>
		<? endif; ?>
		<?= PHtml::submitButton($model->isNewRecord ? "Create" : 'Update', 
			array('name'=>'add_no_more')
		); ?>
	</div>

<? $this->endWidget(); ?>