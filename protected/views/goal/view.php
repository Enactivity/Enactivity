<?php
	$this->pageTitle = 'View Goal' . $model->id;
?>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>

<?php $this->widget('zii.widgets.CDetailView', array(
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
)); ?>
