<?php
	#$this->pageTitle = 'View Goal ' . $model->id;
	$this->pageTitle = $model->name;
	
	$this->pageMenu = MenuDefinitions::goalMenu($model);
?>
<?php 
	foreach ($model->tasks as $task) {
		echo $this->renderPartial('/task/_view', array('data'=>$task));
	}
	
?>
