<div class="wide form">

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="field">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="field">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('maxlength'=>255)); ?>
	</div>

	<div class="field">
		<?php echo $form->label($model,'slug'); ?>
		<?php echo $form->textField($model,'slug',array('maxlength'=>50)); ?>
	</div>

	<div class="field">
		<?php echo $form->label($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
	</div>

	<div class="field">
		<?php echo $form->label($model,'modified'); ?>
		<?php echo $form->textField($model,'modified'); ?>
	</div>

	<div class="field buttons">
		<?php echo PHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->