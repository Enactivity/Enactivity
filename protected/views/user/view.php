<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->fullName(),
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index'), 'visible'=>Yii::app()->user->isAdmin),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id), 'visible'=>Yii::app()->user->isAdmin),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>Yii::app()->user->isAdmin),
	array('label'=>'Manage User', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin),
);
?>

<h1>Viewing <?php echo $model->fullName(); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'username',
		'email',
		'firstName',
		'lastName',
	),
)); ?>
