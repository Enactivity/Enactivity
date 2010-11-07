<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Invite a User', 'url'=>array('invite')),
	array('label'=>'Admin: Create a Group', 'url'=>array('create'), 'visible'=>Yii::app()->user->isAdmin),
	array('label'=>'Admin: Manage Groups', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin),
);
?>

<h1>Create Group</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>