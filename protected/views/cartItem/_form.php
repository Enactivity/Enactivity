<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'cart-item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?= $form->errorSummary($model); ?>

	<div class="field">
		<?= $form->labelEx($model,'sweaterLetters'); ?>
		<?= $form->dropDownList($model,'firstLetter', PHtml::GetGreekLetters()); ?>
		<?= $form->dropDownList($model,'secondLetter', PHtml::GetGreekLetters()); ?>
		<?= $form->dropDownList($model,'thirdLetter', PHtml::GetGreekLetters()); ?>
		<?= $form->dropDownList($model,'fourthLetter', PHtml::GetGreekLetters()); ?>
		<?= $form->error($model,'sweaterLetters'); ?>
	</div>

	<div class="field">
		<?= $form->labelEx($model,'quantity'); ?>
		<?= $form->numberField($model,'quantity', array(
			'min'=>CartItem::QUANTITY_MIN_VALUE,
		)); ?>
		<?= $form->error($model,'quantity'); ?>
	</div>

	<? if(Yii::app()->user->isAdmin) : ?>
	<div class="field">
		<?= $form->labelEx($model,'isDelivered'); ?>
		<?= $form->checkBox($model,'isDelivered'); ?>
		<?= $form->error($model,'isDelivered'); ?>
	</div>
	<? endif; ?>

	<div class="field buttons">
		<?= PHtml::submitButton($model->isNewRecord ? 'Add to Cart' : 'Update'); ?>
	</div>

<? $this->endWidget(); ?>