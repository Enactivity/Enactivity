<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->fullName(),
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
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
