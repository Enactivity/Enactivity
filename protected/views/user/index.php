<?php
$this->pageTitle = 'Users';
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_users',
	'cssFile'=>false,
)); ?>
