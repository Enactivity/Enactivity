<?php
$this->pageTitle = "Create a New Event - " . Yii::app()->name;
$this->breadcrumbs=array(
	'Events'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Admin: Manage Events', 
		'url'=>array('admin'),
		'linkOptions'=>array('id'=>'event_admin_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin,
	),
);
?>

<h1>Create a New Event</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>