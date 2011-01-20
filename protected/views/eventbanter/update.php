<?php

$this->menu=array(
	array('label'=>'List EventBanter', 'url'=>array('index')),
	array('label'=>'Create EventBanter', 'url'=>array('create')),
	array('label'=>'View EventBanter', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EventBanter', 'url'=>array('admin')),
);
?>

<h1>Update EventBanter <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>