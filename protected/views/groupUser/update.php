<?php
$this->breadcrumbs=array(
	'Group Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GroupUser', 'url'=>array('index')),
	array('label'=>'Create GroupUser', 'url'=>array('create')),
	array('label'=>'View GroupUser', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GroupUser', 'url'=>array('admin')),
);
?>

<h1>Update GroupUser <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>