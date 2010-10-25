<?php
$this->breadcrumbs=array(
	'Event Users',
);

$this->menu=array(
	array('label'=>'Create EventUser', 'url'=>array('create')),
	array('label'=>'Manage EventUser', 'url'=>array('admin')),
);
?>

<h1>My Event RSVPs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
