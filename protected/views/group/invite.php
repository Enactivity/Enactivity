<?php 
$this->pageTitle = 'Invite a User';

$this->menu = MenuDefinitions::groupMenu();
?>

<div class="form">

<?php $form=$this->beginWidget('ext.pwidgets.PActiveForm', array(
	'id'=>'invite-form-invite-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php 
	$this->widget('ext.widgets.group.GroupInputRow', array(
		'form' => $form,
		'model' => $model,
		'groups' => Yii::app()->user->model->groups,
	));
	?>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'emails'); ?></div>
		<div class="forminput"><?php echo $form->emailField($model,'emails', 
			array(
				'multiple'=>'',
				'placeholder'=>'One or more emails separated by spaces'
			)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'emails'); ?></div>
	</div>


	<div class="row">
		<div class="buttons"><?php echo PHtml::submitButton('Submit'); ?></div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->