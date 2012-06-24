<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'cart-item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="field">
		<?php echo $form->labelEx($model,'sweaterLetters'); ?>
		<?php echo $form->dropDownList($model,'firstLetter', PHtml::GetGreekLetters()); ?>
		<?php echo $form->dropDownList($model,'secondLetter', PHtml::GetGreekLetters()); ?>
		<?php echo $form->dropDownList($model,'thirdLetter', PHtml::GetGreekLetters()); ?>
		<?php echo $form->error($model,'sweaterLetters'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->numberField($model,'quantity', array(
			'min'=>CartItem::QUANTITY_MIN_VALUE,
		)); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<?php if(Yii::app()->user->isAdmin) : ?>
	<div class="field">
		<?php echo $form->labelEx($model,'isDelivered'); ?>
		<?php echo $form->checkBox($model,'isDelivered'); ?>
		<?php echo $form->error($model,'isDelivered'); ?>
	</div>
	<?php endif; ?>

	<div class="field buttons">
		<?php echo PHtml::submitButton($model->isNewRecord ? 'Add to Cart' : 'Update'); ?>
	</div>

<?php $this->endWidget(); ?>