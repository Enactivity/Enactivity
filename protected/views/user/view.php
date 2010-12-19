<?php

$this->menu=array();
?>

<h1><?php echo $model->fullName; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'email:email',
		'username',
	),
)); ?>
