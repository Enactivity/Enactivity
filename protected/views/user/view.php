<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->fullName,
);

$this->menu=array(
	array('label'=>'Update Profile', 
		'url'=>array('update', 'id'=>$model->id),
		'linkOptions'=>array('id'=>'user_update_menu_item'), 
		'visible'=>Yii::app()->user->id == $model->id,
	),
	array('label'=>'Update Password', 
		'url'=>array('updatepassword', 'id'=>$model->id),
		'linkOptions'=>array('id'=>'user_update_menu_item'), 
		'visible'=>Yii::app()->user->id == $model->id,
	),
);
?>

<h1><?php echo $model->fullName; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'email:email',
		'username',
	),
)); ?>
