<?php
$this->breadcrumbs=array(
	'Groups',
);

$this->menu=array(
	array('label'=>'Invite a User', 
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

<h1>Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
