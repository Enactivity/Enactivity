<?
/**
* Partial view to display the easy feedback form for users
* @author Harrison Vuong
**/
?>

<section class="content">
	<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
		'id'=>'feedback-form',
		'enableClientValidation'=>false,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>
	
	<?= $form->errorSummary($model); ?>
		<fieldset>
			<div class="field">
				<?= $form->labelEx($model,'message'); ?>
				<?= $form->textArea($model,'message', array(
					'placeholder'=>'How can we make ' . PHtml::encode(Yii::app()->name) . ' better today?'
				)); ?>
				<?= $form->error($model,'message'); ?>
			</div>
		</fieldset>

		<div class="field buttons">
			<?= PHtml::submitButton('Submit'); ?>
		</div>

	<?php $this->endWidget(); ?>
</section>