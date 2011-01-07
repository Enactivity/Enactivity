<?php
$this->pageTitle = "Create GroupBanter";

$this->menu=array(
	array('label'=>'List GroupBanter', 'url'=>array('index')),
	array('label'=>'Manage GroupBanter', 'url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>