<div class="form">

<?php $form=$this->beginWidget('ext.pwidgets.PActiveForm', array(
	'id'=>'event-banter-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<div class="forminput"><?php echo $form->textArea($model,'content',
			array(
				'maxlength'=>EventBanter::CONTENT_MAX_LENGTH,
				'rows'=>5,
				'placeholder'=>'What\'s up?',
			)); 
		?></div>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->