<?php
	$this->pageTitle = 'What\'s Next';

// "what would you want to do input" box
echo $this->renderPartial('_form', array('model'=>$model));

foreach ($tasks as $task) {
	$this->renderPartial('/task/_view', array('data'=>$task));
}