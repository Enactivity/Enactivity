<?php
$this->pageTitle = 'Users';
$this->menu=array();
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_users',
	'cssFile'=>false,
)); ?>
