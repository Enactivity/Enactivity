<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sweater-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'style'); ?>
		<?php echo $form->textField($model,'style',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'style'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clothColor'); ?>
		<?php echo $form->textField($model,'clothColor',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'clothColor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'letterColor'); ?>
		<?php echo $form->textField($model,'letterColor',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'letterColor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stitchingColor'); ?>
		<?php echo $form->textField($model,'stitchingColor',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'stitchingColor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'size'); ?>
		<?php echo $form->textField($model,'size',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'available'); ?>
		<?php echo $form->textField($model,'available'); ?>
		<?php echo $form->error($model,'available'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified'); ?>
		<?php echo $form->textField($model,'modified'); ?>
		<?php echo $form->error($model,'modified'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->