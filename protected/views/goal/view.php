<?php
$this->pageTitle = $model->name;

$this->pageMenu = MenuDefinitions::goalMenu($model);

// render a form to add a new task
$this->widget('application.components.widgets.forms.TaskForm', 
	array(
		'goal' => $model,
	)
);

// list the tasks
$this->widget('zii.widgets.CListView', 
	array(
		'dataProvider'=>$tasks,
		'itemView'=>'/task/_view',
	)
);
