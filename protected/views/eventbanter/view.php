<?php

?>

<h1>View EventBanter #<?php echo $model->id; ?></h1>

<?php $this->widget('application.components.widgets.DetailView', array(
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
