<?php
$this->breadcrumbs=array(
	'Event Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EventUser', 'url'=>array('index')),
	array('label'=>'Manage EventUser', 'url'=>array('admin')),
);
?>

<h1>Create EventUser</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>