<?
/**
 * 
 */
?>

<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'checkout-form',
	'action'=> isset($action) ? $action : '',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'class'=>$classForm,
	),
)); ?>

	<?= $form->errorSummary($model); ?>
	
	<div class="field">
		<div class="formlabel"><?= $form->labelEx($model,'phoneNumber'); ?></div>
		<div class="forminput"><?= $form->textField($model,'phoneNumber',
			array('maxlength'=>User::PHONENUMBER_MAX_LENGTH)); ?></div>
		<div class="formerrors"><?= $form->error($model,'phoneNumber'); ?></div>
	</div>

	<div class="field buttons">
		<?= PHtml::submitButton('Place order'); ?>
	</div>

<? $this->endWidget(); ?>