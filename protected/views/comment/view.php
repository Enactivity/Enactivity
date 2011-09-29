<h1>View Comment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'groupId',
		'creatorId',
		'model',
		'modelId',
		'content',
		'created',
		'modified',
	),
)); ?>
