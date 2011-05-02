<?php
	$this->pageTitle = 'Create Task';
?>

<?php 
// render a form to add a new task
$this->widget('ext.widgets.forms.TaskForm', 
	array(
		'goal' => $model,
		'task' => $task, 
	)
);