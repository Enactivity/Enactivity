<?php 
$this->pageTitle = 'Invite a User';

$this->menu=array(
	array('label'=>'Invite a User', 
		'url'=>array('group/invite'),
		'linkOptions'=>array('id'=>'group_invite_menu_item'),
	),
);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invite-form-invite-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'groupId'); ?></div>
		<div class="forminput"><?php echo $form->dropDownList($model, 'groupId', 
			CHtml::listData($userGroups, 'id', 'name'),
			array('autofocus'=>'autofocus')); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'groupId'); ?></div>
	</div>

	<div class="row">
		<div class="formlabel"><?php echo $form->labelEx($model,'emails'); ?></div>
		<div class="forminput"><?php echo $form->textField($model,'emails'); ?></div>
		<div class="formerrors"><?php echo $form->error($model,'emails'); ?></div>
	</div>


	<div class="row">
		<div class="buttons"><?php echo CHtml::submitButton('Submit'); ?></div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->