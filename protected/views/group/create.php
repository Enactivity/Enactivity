<?php
$this->pageTitle = 'Create a New Group - ' . Yii::app()->name;
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Invite a User', 
		'url'=>array('invite'),
		'linkOptions'=>array('id'=>'group_invite_menu_item'),
	),
);
?>

<h1>Create a Group</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>