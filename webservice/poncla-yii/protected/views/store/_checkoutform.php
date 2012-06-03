<?php
/**
 * 
 */
?>

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'checkout-form',
	'action'=> isset($action) ? $action : '',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'class'=>$classForm,
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="field">
		<div class="formlabel"><?php echo $form->labelEx($model,'phoneNumber'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'phoneNumber',
			array('maxlength'=>User::PHONENUMBER_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'phoneNumber'); ?></div>
	</div>

	<div class="field buttons">
		<?php echo PHtml::submitButton('Place order'); ?>
	</div>

<?php $this->endWidget(); ?>