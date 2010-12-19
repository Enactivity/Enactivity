<?php
$this->pageTitle = $model->name;

$this->menu=array(
	array('label'=>'Create an Event', 
		'url'=>array('create'),
		'linkOptions'=>array('id'=>'event_create_menu_item'),
	),
	array('label'=>'Delete This Event', 
		'url'=>'#', 
		'linkOptions'=>array('submit'=>array(
				'delete',
				'id'=>$model->id,
			), 
			'confirm'=>'Are you sure you want to delete this item?',
			'csrf' => true,
			'id'=>'event_delete_menu_item',
		),
	),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>