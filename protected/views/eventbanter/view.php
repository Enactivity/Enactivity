<?php

?>

<h1>View EventBanter #<?php echo $model->id; ?></h1>

<?php $this->widget('ext.widgets.DetailView', array(
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
