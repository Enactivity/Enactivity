<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'goal-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php 
	if($model->getScenario() == Goal::SCENARIO_INSERT
	|| $model->getScenario() == Goal::SCENARIO_UPDATE):
	?>
	<?php 
	if($model->isNewRecord) { 
		$this->widget('application.components.widgets.inputs.GroupInputRow', array(
			'form' => $form,
			'model' => $model,
			'groups' => Yii::app()->user->model->groups,
		));
	}
	?>
	<?php endif; ?>
	<?php echo $form->errorSummary($model); ?>
	<?php 
	if($model->getScenario() == Goal::SCENARIO_INSERT
	|| $model->getScenario() == Goal::SCENARIO_UPDATE):
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textArea($model,'name',array(
			'maxlength'=>Goal::NAME_MAX_LENGTH,
		)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<?php endif; ?>
	<?php 
	if($model->getScenario() == Goal::SCENARIO_TRASH
	|| $model->getScenario() == Goal::SCENARIO_UNTRASH):
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'isTrash'); ?>
		<?php echo $form->textField($model,'isTrash'); ?>
		<?php echo $form->error($model,'isTrash'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>