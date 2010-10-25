<?php
$this->breadcrumbs=array(
	'Group Users',
);

$this->menu=array(
	array('label'=>'Create GroupUser', 'url'=>array('create')),
	array('label'=>'Manage GroupUser', 'url'=>array('admin')),
);
?>

<h1>My Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 
?>
