<div class="wide form">

<? $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?= $form->label($model,'id'); ?>
		<?= $form->textField($model,'id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'groupId'); ?>
		<?= $form->textField($model,'groupId',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'creatorId'); ?>
		<?= $form->textField($model,'creatorId',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'model'); ?>
		<?= $form->textField($model,'model',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'modelId'); ?>
		<?= $form->textField($model,'modelId',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'content'); ?>
		<?= $form->textField($model,'content',array('size'=>60,'maxlength'=>4000)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'created'); ?>
		<?= $form->textField($model,'created'); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'modified'); ?>
		<?= $form->textField($model,'modified'); ?>
	</div>

	<div class="row buttons">
		<?= CHtml::submitButton('Search'); ?>
	</div>

<? $this->endWidget(); ?>

</div><!-- search-form -->