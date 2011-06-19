<?php
$this->pageTitle = $model->fullName;
?>

<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'email:email',
	),
)); ?>
