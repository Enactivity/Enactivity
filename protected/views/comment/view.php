<h1>View Comment #<?= $model->id; ?></h1>

<? $this->widget('zii.widgets.CDetailView', array(
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
