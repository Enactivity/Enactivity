<div class="form">
<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?= $form->errorSummary($model); ?>

	<div class="field">
		<?= $form->textArea($model,'message',array(
			// 'maxlength'=>Comment::CONTENT_MAX_LENGTH,
			'placeholder'=>'What\'s up?',
		)); ?>
		<?= $form->error($model,'message'); ?>
	</div>

	<div class="field buttons">
		<?= CHtml::submitButton('Post Comment'); ?>
	</div>

<? $this->endWidget(); ?>

</div><!-- form -->