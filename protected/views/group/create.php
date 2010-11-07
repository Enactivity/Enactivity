<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Invite a User', 'url'=>array('invite')),
	array('label'=>'Admin: Create a Group', 'url'=>array('create')),
	array('label'=>'Admin: Manage Groups', 'url'=>array('admin')),
);
?>

<h1>Create Group</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>