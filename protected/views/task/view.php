<h1>View Task #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'goalId',
		'name',
		'ownerId',
		'priority',
		'isCompleted',
		'isTrash',
		'starts',
		'ends',
		'created',
		'modified',
	),
)); ?>
