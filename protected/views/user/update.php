<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List User', 
		'url'=>array('index'), 
		'linkOptions'=>array('id'=>'user_index_menu_item'),
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'View User', 
		'url'=>array('view', 'id'=>$model->id), 
		'linkOptions'=>array('id'=>'user_view_menu_item'),
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Manage User', 
		'url'=>array('admin'),
		'linkOptions'=>array('id'=>'user_admin_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin
	),
);
?>

<h1>Update User <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>