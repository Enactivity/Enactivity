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
        <?php echo $form->labelEx($model,'groupId'); ?>
        <?php echo $form->dropDownList($model, 'groupId', CHtml::listData($userGroups, 'id', 'name')); ?>
        <?php echo $form->error($model,'groupId'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'emails'); ?>
        <?php echo $form->textField($model,'emails'); ?>
        <?php echo $form->error($model,'emails'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->