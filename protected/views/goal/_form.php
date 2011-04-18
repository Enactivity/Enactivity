<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'goal-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php 
	if($model->getScenario() == Goal::SCENARIO_INSERT
	|| $model->getScenario() == Goal::SCENARIO_UPDATE):
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<?php endif; ?>
	<?php 
	if($model->getScenario() == Goal::SCENARIO_INSERT
	|| $model->getScenario() == Goal::SCENARIO_UPDATE):
	?>
	<div class="row">
	<?php 
	if($model->isNewRecord) { 
		$this->widget('ext.widgets.inputs.GroupInputRow', array(
			'form' => $form,
			'model' => $model,
			'groups' => Yii::app()->user->model->groups,
		));
	}
	?>
	</div>
	<?php endif; ?>
	<?php 
	if($model->getScenario() == Goal::SCENARIO_INSERT
	|| $model->getScenario() == Goal::SCENARIO_UPDATE):
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'ownerId'); ?>
		<?php echo $form->textField($model,'ownerId'); ?>
		<?php echo $form->error($model,'ownerId'); ?>
	</div>
	<?php endif; ?>
	<?php 
	if($model->getScenario() == Goal::SCENARIO_UPDATE):
	?>	
	<div class="row">
		<?php echo $form->labelEx($model,'isCompleted'); ?>
		<?php echo $form->checkBox($model,'isCompleted'); ?>
		<?php echo $form->error($model,'isCompleted'); ?>
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

</div><!-- form -->