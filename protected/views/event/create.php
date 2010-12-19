<?php
$this->pageTitle = "Create a New Event - " . Yii::app()->name;
$this->breadcrumbs=array(
	'Events'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Create an Event', 
		'url'=>array('create'),
		'linkOptions'=>array('id'=>'event_create_menu_item'),
	),
);
?>

<h1>Create a New Event</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>