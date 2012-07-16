<div class="wide form">

<? $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="field">
		<?= $form->label($model,'id'); ?>
		<?= $form->textField($model,'id'); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'groupId'); ?>
		<?= $form->textField($model,'groupId'); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'name'); ?>
		<?= $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'isTrash'); ?>
		<?= $form->textField($model,'isTrash'); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'starts'); ?>
		<?= $form->textField($model,'starts'); ?>
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
		<?= CHtml::submitButton('Search'); ?>
	</div>

<? $this->endWidget(); ?>

</div><!-- search-form -->