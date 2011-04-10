<?php
$this->breadcrumbs=array(
	'Goals'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Goal', 'url'=>array('index')),
	array('label'=>'Create Goal', 'url'=>array('create')),
	array('label'=>'View Goal', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Goal', 'url'=>array('admin')),
);
?>

<h1>Update Goal <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>