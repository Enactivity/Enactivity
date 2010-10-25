<?php
$this->breadcrumbs=array(
	'Event Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EventUser', 'url'=>array('index')),
	array('label'=>'Create EventUser', 'url'=>array('create')),
	array('label'=>'Update EventUser', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EventUser', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EventUser', 'url'=>array('admin')),
);
?>

<h1>View EventUser #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'eventId',
		'userId',
		'status',
		'created',
		'modified',
	),
)); ?>
