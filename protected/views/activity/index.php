<?php
/* @var $this ActivityController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Activities';
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
