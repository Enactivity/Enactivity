<?php
$this->pageTitle = $model->fullName;
$this->menu=array();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'email:email',
		'username',
	),
)); ?>
