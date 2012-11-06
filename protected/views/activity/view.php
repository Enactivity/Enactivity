<?php
/* @var $this ActivityController */
/* @var $model Activity */

$this->pageTitle = $model->name;
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'groupId',
		'authorId',
		'facebookId',
		'name',
		'description',
		'status',
		'participantsCount',
		'participantsCompletedCount',
		'created',
		'modified',
	),
)); ?>
