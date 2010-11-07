<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Invite a User', 'url'=>array('invite')),
	array('label'=>'Admin: Create a Group', 'url'=>array('create')),
	array('label'=>'Admin: Delete This Group', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Admin: Manage Groups', 'url'=>array('admin')),
);
?>

<h1>Update Group <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>