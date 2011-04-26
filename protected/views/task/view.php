<?php
$this->pageTitle = $model->name;
$this->pageMenu = MenuDefinitions::taskMenu($model);

$this->widget('ext.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name' => 'name',
			'visible' => strlen($model->name) > 0 ? true : false,
		),
		array(
			'name' => 'ownerId',
			'visible' => strlen($model->name) > 0 ? true : false,
		),
		array( 
			'name' => 'starts',
			'type' => 'styledtext',
		),
		array( 
			'name' => 'ends',
			'type' => 'styledtext',
		),
	),
)); 
?>