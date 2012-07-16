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
		<?= $form->label($model,'userId'); ?>
		<?= $form->textField($model,'userId',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'productType'); ?>
		<?= $form->textField($model,'productType',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'productId'); ?>
		<?= $form->textField($model,'productId',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'quantity'); ?>
		<?= $form->textField($model,'quantity'); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'purchased'); ?>
		<?= $form->textField($model,'purchased'); ?>
	</div>

	<div class="row">
		<?= $form->label($model,'delivered'); ?>
		<?= $form->textField($model,'delivered'); ?>
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