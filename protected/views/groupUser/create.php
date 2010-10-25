<?php
$this->breadcrumbs=array(
	'Group Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GroupUser', 'url'=>array('index')),
	array('label'=>'Manage GroupUser', 'url'=>array('admin')),
);
?>

<h1>Create GroupUser</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>