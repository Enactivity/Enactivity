<div class="wide form">

<? $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?= $form->label($model,'id'); ?>
		<?= $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'style'); ?>
		<?= $form->textField($model,'style',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'clothColor'); ?>
		<?= $form->textField($model,'clothColor',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'letterColor'); ?>
		<?= $form->textField($model,'letterColor',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'stitchingColor'); ?>
		<?= $form->textField($model,'stitchingColor',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'size'); ?>
		<?= $form->textField($model,'size',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'available'); ?>
		<?= $form->textField($model,'available'); ?>
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