<?php
$this->pageTitle = $model->fullName;
$this->pageMenu = MenuDefinitions::userMenu($model);
?>

<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'email:email',
	),
)); ?>
