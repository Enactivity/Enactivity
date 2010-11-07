<?php
$this->breadcrumbs=array(
	'Events'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Events', 'url'=>array('index')),
	array('label'=>'Admin: Manage Events', 'url'=>array('admin')),
);
?>

<h1>Create Event</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>