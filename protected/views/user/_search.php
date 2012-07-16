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
		<?= $form->label($model,'email'); ?>
		<?= $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'token'); ?>
		<?= $form->textField($model,'token',array('size'=>40,'maxlength'=>40)); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'firstName'); ?>
		<?= $form->textField($model,'firstName',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'lastName'); ?>
		<?= $form->textField($model,'lastName',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'status'); ?>
		<?= $form->textField($model,'status',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'created'); ?>
		<?= $form->textField($model,'created'); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'modified'); ?>
		<?= $form->textField($model,'modified'); ?>
	</div>

	<div class="field">
		<?= $form->label($model,'lastLogin'); ?>
		<?= $form->textField($model,'lastLogin'); ?>
	</div>

	<div class="field buttons">
		<?= PHtml::submitButton('Search'); ?>
	</div>

<? $this->endWidget(); ?>

</div><!-- search-form -->