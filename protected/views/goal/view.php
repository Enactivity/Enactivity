<?php
$this->pageTitle = $model->name;

$this->pageMenu = MenuDefinitions::goalMenu($model);
	
$this->widget('zii.widgets.CListView', 
	array(
		'dataProvider'=>$tasks,
	'itemView'=>'/task/_view',
	)
); ?>
