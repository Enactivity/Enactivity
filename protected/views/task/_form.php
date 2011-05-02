<div class="form">

<?php $form=$this->beginWidget('ext.widgets.ActiveForm', array(
	'id'=>'task-form',
	'action'=>array('task/create'),
	'enableAjaxValidation'=>false,
)); ?>

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

	<div class="row">
		<?php echo $form->labelEx($model,'starts'); ?>
		<?php echo $form->textField($model,'starts'); ?>
		<?php echo $form->error($model,'starts'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ends'); ?>
		<?php echo $form->textField($model,'ends'); ?>
		<?php echo $form->error($model,'ends'); ?>
	</div>
	<?php endif; ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->