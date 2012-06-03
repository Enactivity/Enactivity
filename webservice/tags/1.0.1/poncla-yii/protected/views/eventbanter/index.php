<?php

$this->menu=array(
	array('label'=>'Create EventBanter', 'url'=>array('create')),
	array('label'=>'Manage EventBanter', 'url'=>array('admin')),
);
?>

<h1>Event Banters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
