<?php
$this->breadcrumbs=array(
	'Register',
);

$this->menu=array(
	array('label'=>'Admin: List User', 'url'=>array('index'), 'visible'=>Yii::app()->user->isAdmin),
	array('label'=>'Admin: Manage User', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin),
);
?>

<h1>Register</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>