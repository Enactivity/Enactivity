<?php
$this->breadcrumbs=array(
	'Event Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EventUser', 'url'=>array('index')),
	array('label'=>'Create EventUser', 'url'=>array('create')),
	array('label'=>'View EventUser', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EventUser', 'url'=>array('admin')),
);
?>

<h1>Update EventUser <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>