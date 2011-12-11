<?php 
$this->pageTitle = 'Invite People';

?>

<?php echo PHtml::beginContentHeader(); ?>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

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
		<div class="forminput">
			<?php echo $form->textArea($model,'emails', 
				array(
					'placeholder'=>'@, @, @...'
				)
			); ?>
		</div>
	</div>


	<div class="field buttons">
		<?php echo PHtml::submitButton('Invite'); ?>
	</div>

<?php $this->endWidget(); ?>