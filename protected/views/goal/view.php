<?php
$this->pageTitle = $model->name;

$this->pageMenu = MenuDefinitions::goalMenu($model);

// render a form to add a new task
$this->renderPartial('/task/_form', array('model'=>$task));

// list the tasks
$this->widget('zii.widgets.CListView', 
	array(
		'dataProvider'=>$tasks,
		'itemView'=>'/task/_view',
	)
);
