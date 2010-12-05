<?php 
$this->pageTitle = 'Invite a User - ' . Yii::app()->name;
$this->breadcrumbs=array(
	'Invite',
);

$this->menu=array(
	array('label'=>'Invite a New User', 
		'url'=>array('invite'),
		'linkOptions'=>array('id'=>'group_invite_menu_item'),
	),
	array('label'=>'Admin: Create a Group', 
		'url'=>array('create'),
		'linkOptions'=>array('id'=>'group_create_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Admin: Manage Groups', 
		'url'=>array('admin'), 
		'linkOptions'=>array('id'=>'group_admin_menu_item'),
		'visible'=>Yii::app()->user->isAdmin
	),
);
?>
<h1>Invite a User</h1>

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