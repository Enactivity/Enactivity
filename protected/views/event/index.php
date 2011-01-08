<?php
$this->pageTitle = 'Events';

$this->menu = MenuDefinitions::eventMenu();
?>

<?php 
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 
?>
