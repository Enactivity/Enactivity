<?php
$this->pageTitle = 'Events';

$this->menu=array(
	array('label'=>'Create an Event', 
		'url'=>array('create'),
		'linkOptions'=>array('id'=>'event_create_menu_item'),
	),
);
?>

<?php 
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 
?>
