<?php

$this->menu=array(
	array('label'=>'List GroupBanter', 'url'=>array('index')),
	array('label'=>'Create GroupBanter', 'url'=>array('create')),
	array('label'=>'View GroupBanter', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GroupBanter', 'url'=>array('admin')),
);
?>

<h1>Update GroupBanter <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>