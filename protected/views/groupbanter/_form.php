<div class="form">

<?php $form=$this->beginWidget('ext.pwidgets.PActiveForm', array(
	'id'=>'group-banter-form',
	'enableAjaxValidation'=>false,
	'action'=>$action,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<div class="forminput"><?php echo $form->textArea($model,'content',
			array(
				'maxlength'=>GroupBanter::CONTENT_MAX_LENGTH,
				'rows'=>5,
				'placeholder'=>'What\'s up?',
			)); 
		?></div>
		<?php echo $form->error($model,'content'); ?>
	</div>
	
	<?php 
	// Only show group selection on non-replies
	if($model->scenario != GroupBanter::SCENARIO_REPLY):
		$this->widget('ext.widgets.group.GroupInputRow', array(
			'form' => $form,
			'model' => $model,
			'groups' => Yii::app()->user->model->groups,
		));
	endif;
	?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Start a conversation' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->