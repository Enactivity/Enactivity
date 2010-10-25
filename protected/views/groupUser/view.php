<?php
$this->breadcrumbs=array(
	'Group Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GroupUser', 'url'=>array('index')),
	array('label'=>'Create GroupUser', 'url'=>array('create')),
	array('label'=>'Update GroupUser', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GroupUser', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GroupUser', 'url'=>array('admin')),
);
?>

<h1>View GroupUser #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'groupId',
		'userId',
		'status',
		'created',
		'modified',
	),
)); ?>
