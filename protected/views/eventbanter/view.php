<?php

$this->menu=array(
	array('label'=>'List EventBanter', 'url'=>array('index')),
	array('label'=>'Create EventBanter', 'url'=>array('create')),
	array('label'=>'Update EventBanter', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EventBanter', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EventBanter', 'url'=>array('admin')),
);
?>

<h1>View EventBanter #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'creatorId',
		'eventId',
		'content',
		'created',
		'modified',
	),
)); ?>
