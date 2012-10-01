<div class="wide form">

<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="field">
		<?= $form->label($model,'id'); ?>
		<?= $form->textField($model,'id'); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'name'); ?>
		<?= $form->textField($model,'name',array('maxlength'=>255)); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'slug'); ?>
		<?= $form->textField($model,'slug',array('maxlength'=>50)); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'created'); ?>
		<?= $form->textField($model,'created'); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'modified'); ?>
		<?= $form->textField($model,'modified'); ?>
	</div>

	<div class="field buttons">
		<?= PHtml::submitButton('Search'); ?>
	</div>

<? $this->endWidget(); ?>

</div><!-- search-form -->