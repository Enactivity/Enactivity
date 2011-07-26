<?php 
$this->pageTitle = 'Invite People';

?>

<header>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
</header>

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'invite-form-invite-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php 
	$this->widget('application.components.widgets.inputs.GroupInputRow', array(
		'form' => $form,
		'model' => $model,
		'groups' => Yii::app()->user->model->groups,
		'showAllGroupsOnAdmin' => true,
	));
	?>

	<div class="field">
		<div class="formlabel"><?php echo $form->labelEx($model,'emails'); ?></div>
		<div class="forminput"><?php echo $form->emailField($model,'emails', 
			array(
				'multiple'=>'multiple',
				'placeholder'=>'One or more emails separated by commas'
			)); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'emails'); ?></div>
	</div>


	<div class="field buttons">
		<?php echo PHtml::submitButton('Invite'); ?>
	</div>

<?php $this->endWidget(); ?>