<?php
$this->pageTitle = 'Create an Event';

$this->menu=array(
	array('label'=>'Create an Event', 
		'url'=>array('create'),
		'linkOptions'=>array('id'=>'event_create_menu_item'),
	),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>