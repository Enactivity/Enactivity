<div class="form">

<?php $form=$this->beginWidget('ext.pwidgets.PActiveForm', array(
	'id'=>'group-banter-form',
	'enableAjaxValidation'=>false,
	'action'=>$action,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<div class="forminput"><?php echo $form->textArea($model,'content',
			array(
				'maxlength'=>GroupBanter::CONTENT_MAX_LENGTH,
				'rows'=>5,
				'autofocus'=>'autofocus',
				'placeholder'=>'What\'s up?',
			)); 
		?></div>
		<?php echo $form->error($model,'content'); ?>
	</div>
	
	<?php 
	// Only show group selection on non-replies
	if($model->scenario != GroupBanter::SCENARIO_REPLY):
	?>
	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'groupId'); ?></div>
		<div class="forminput"><?php echo $form->dropDownList($model, 'groupId', 
			PHtml::listData(Yii::app()->user->model->groups, 'id', 'name')); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'groupId'); ?></div>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->