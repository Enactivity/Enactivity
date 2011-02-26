<?php 
$this->pageTitle = 'Invite a User';

?>

<?php $form=$this->beginWidget('ext.widgets.ActiveForm', array(
	'id'=>'invite-form-invite-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php 
	$this->widget('ext.widgets.inputs.GroupInputRow', array(
		'form' => $form,
		'model' => $model,
		'groups' => Yii::app()->user->model->groups,
		'showAllGroupsOnAdmin' => true,
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


	<div class="row buttons">
		<?php echo PHtml::submitButton('Invite'); ?>
	</div>

<?php $this->endWidget(); ?>