<?php
$this->breadcrumbs=array(
	'Users',
);

$this->menu=array(
	array('label'=>'Admin: Manage User', 
		'url'=>array('admin'),
		'linkOptions'=>array('id'=>'user_admin_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin,
	),
);
?>

<h1>Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
