<?php
$this->pageTitle = "Events - " . Yii::app()->name;
$this->breadcrumbs=array(
	'Events',
);

$this->menu=array(
	array('label'=>'Create a New Event', 
		'url'=>array('create'),
		'linkOptions'=>array('id'=>'event_create_menu_item'),
	),
);
?>

<h1>Events</h1>

<?php 
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 
?>
