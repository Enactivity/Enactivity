<?php
	#$this->pageTitle = 'View Goal ' . $model->id;
	$this->pageTitle = $model->name;
	
	$this->pageMenu = MenuDefinitions::goalMenu($model);
?>
<p>
<?php 
/**
	$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'groupId',
		'ownerId',
		'isCompleted',
		'isTrash',
		'created',
		'modified',
	),
)); **/?>
</p>
<?php 
	foreach ($model->tasks as $task) {
		echo $this->renderPartial('/task/_view', array('data'=>$task));
	}
	
?>
