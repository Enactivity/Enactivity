<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->fullName,
);

$this->menu=array(
	array('label'=>'Admin: List User', 
		'url'=>array('index'),
		'linkOptions'=>array('id'=>'user_index_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Admin: Update User', 
		'url'=>array('update', 'id'=>$model->id),
		'linkOptions'=>array('id'=>'user_update_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Admin: Delete User', 
		'url'=>'#', 
		'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),
			'confirm'=>'Are you sure you want to delete this item?',
			'id'=>'user_delete_menu_item',
		), 
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Admin: Manage User', 
		'url'=>array('admin'), 
		'visible'=>Yii::app()->user->isAdmin
	),
);
?>

<h1><?php echo $model->fullName; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'username',
		'email',
		'firstName',
		'lastName',
	),
)); ?>
