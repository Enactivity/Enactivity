<?php 
$this->pageTitle = 'Discover a better way to interact with your group'; 
?>

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'contact-form',
	//'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<h2>Sign up for news about our launch.</h2>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'email'); ?></div>
		<div class="forminput"><?php echo $form->emailField($model,'email', 
			array(
				'placeholder'=>'@',
				'autofocus'=>'autofocus',
			)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'email'); ?></div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Notify me'); ?>
	</div>

<?php $this->endWidget(); ?>