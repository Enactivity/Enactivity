<?php
$this->pageTitle = 'Events';
?>

<?php 
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'emptyText' => 'No future events posted.  Why don\'t you schedule one?',
)); 
?>
