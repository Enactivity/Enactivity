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
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="field">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>4000)); ?>
	</div>

	<div class="field">
		<?php echo $form->label($model,'creatorId'); ?>
		<?php echo $form->textField($model,'creatorId'); ?>
	</div>

	<div class="field">
		<?php echo $form->label($model,'groupId'); ?>
		<?php echo $form->textField($model,'groupId'); ?>
	</div>

	<div class="field">
		<?php echo $form->label($model,'starts'); ?>
		<?php echo $form->textField($model,'starts'); ?>
	</div>

	<div class="field">
		<?php echo $form->label($model,'ends'); ?>
		<?php echo $form->textField($model,'ends'); ?>
	</div>

	<div class="field">
		<?php echo $form->label($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>255)); ?>
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