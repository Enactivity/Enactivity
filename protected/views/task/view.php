<?php
$this->pageTitle = $model->name;
?>
<?php $this->widget('ext.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name' => 'name',
			'visible' => strlen($model->name) > 0 ? true : false,
		),
		array(
			'name' => 'owner',
			'visible' => strlen($model->name) > 0 ? true : false,
		),
		array( 
			'name' => 'starts',
			'type' => 'styledtext',
		),
		array( 
			'name' => 'ends',
			'type' => 'styledtext',
		),
	),
)); 
?>
<!--
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
-->