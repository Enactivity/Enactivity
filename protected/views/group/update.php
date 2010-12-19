<?php
$this->pageTitle = 'Update - ' . $model->name . ' - ' . Yii::app()->name;
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Invite a User', 
		'url'=>array('group/invite'),
		'linkOptions'=>array('id'=>'group_invite_menu_item'),
	),
	array('label'=>'Update This Group', 
		'url'=>array('group/updateprofile'),
		'linkOptions'=>array('id'=>'group_profile_menu_item'),
	),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>