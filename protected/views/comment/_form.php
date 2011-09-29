<div class="form">

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="field">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array(
			'maxlength'=>Comment::CONTENT_MAX_LENGTH,
			'placeholder'=>'What\'s up?',
		)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="field buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Post Comment' : 'Update Comment'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->