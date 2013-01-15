<?php
/**
 * @uses $this ActivityController
 * @var $model Activity
 * @var $form CActiveForm
 **/
?>

<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
	'id'=>'activity-form',
	'action'=> isset($action) ? $action : '',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'class'=>$classForm,
	),
)); ?>

	<?= $form->errorSummary($model); ?>

	<fieldset>

		<? if($model->isNewRecord) {
			$this->widget('application.components.widgets.inputs.GroupInputRow', array(
					'form' => $form,
					'model' => $model,
					'groups' => Yii::app()->user->model->groups,
			));
		} ?>

		<div class="field">
			<?= $form->labelEx($model,'name'); ?>
			<?= $form->textField($model,'name',array(
				'size'=>60,
				'maxlength'=>255,
				'placeholder'=>'What\'s to be done?'
			)); ?>
			<?= $form->error($model,'name'); ?>
		</div>

		<div class="field">
			<?= $form->labelEx($model,'description'); ?>
			<?= $form->textArea($model,'description',array(
				'fields'=>6, 
				'cols'=>50,
				'placeholder'=>'More details if needed.',
			)); ?>
			<?= $form->error($model,'description'); ?>
		</div>

	</fieldset>

	<div class="field buttons">
		<? if($model->isTrashable): ?>
		<?= PHtml::button(
			PHtml::encode('Trash'), array( //html				
				'submit'=>array('activity/trash', 'id'=>$model->id),
				'csrf'=>true,
				'id'=>'activity-trash-menu-item-' . $model->id,
				'class'=>'neutral activity-trash-menu-item',
				'title'=>'Trash this activity',
			)); ?>
		<? endif; ?>
		<? if($model->isUntrashable): ?>
		<?= PHtml::button(
			PHtml::encode('Restore'), array( //html
				'submit'=>array('activity/untrash', 'id'=>$model->id),
				'csrf'=>true,
				'id'=>'activity-untrash-menu-item-' . $model->id,
				'class'=>'positive activity-untrash-menu-item',
				'title'=>'Restore this activity',
			)); ?>
		<? endif; ?>
		<?= PHtml::submitButton($model->isNewRecord ? 'I\'m ready to add some tasks' : 'Update'); ?>
	</div>

<?php $this->endWidget(); ?>