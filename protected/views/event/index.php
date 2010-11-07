<?php
$this->breadcrumbs=array(
	'Events',
);

$this->menu=array(
	array('label'=>'Create a New Event', 'url'=>array('create')),
	array('label'=>'Admin: Manage Events', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin),
);
?>

<h1>Events</h1>

<?php 
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 
?>
