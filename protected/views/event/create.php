<?php
$this->pageTitle = "Create a New Event - " . Yii::app()->name;
$this->breadcrumbs=array(
	'Events'=>array('index'),
	'Create',
);

$this->menu=array(
	array(),
);
?>

<h1>Create a New Event</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>