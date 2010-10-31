<?php
$this->breadcrumbs=array(
	'Groups',
);

$this->menu=array(
array('label'=>'Create Group', 'url'=>array('create'), 'visible'=>Yii::app()->user->isAdmin),
array('label'=>'Manage Group', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin),
);
?>

<h1>Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
