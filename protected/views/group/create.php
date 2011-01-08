<?php
$this->pageTitle = 'Create a Group';

$this->menu=array(
	array('label'=>'Manage Events', 
		'url'=>array('event/admin'), 
		'linkOptions'=>array('id'=>'event_admin_menu_item'),
		'visible'=>Yii::app()->user->isAdmin,
	),
	array('label'=>'Manage Users', 
		'url'=>array('user/admin'),
		'linkOptions'=>array('id'=>'user_admin_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Create Group', 
		'url'=>array('group/create'),
		'linkOptions'=>array('id'=>'group_create_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Manage Groups', 
		'url'=>array('group/admin'), 
		'linkOptions'=>array('id'=>'group_manage_menu_item'),
		'visible'=>Yii::app()->user->isAdmin,
	),
	array('label'=>'Manage GroupBanter', 
		'url'=>array('groupbanter/admin'), 
		'linkOptions'=>array('id'=>'groupbanter_manage_menu_item'),
		'visible'=>Yii::app()->user->isAdmin,
	),
);

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>