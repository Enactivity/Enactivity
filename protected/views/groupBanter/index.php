<?php
$this->pageTitle = 'Banter';

$this->menu=array(
	array('label'=>'Create GroupBanter', 'url'=>array('groupbanter/create')),
	array('label'=>'Manage GroupBanter', 'url'=>array('groupbanter/admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
