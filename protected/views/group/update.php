<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Invite a User', 
		'url'=>array('invite'),
		'linkOptions'=>array('id'=>'group_invite_menu_item'),
	),
	array('label'=>'Admin: Create a Group', 
		'url'=>array('create'),
		'linkOptions'=>array('id'=>'group_create_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Admin: Delete This Group', 
		'url'=>'#', 
		'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),
			'confirm'=>'Are you sure you want to delete this group?',
			'id'=>'group_delete_menu_item',
			), 
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Admin: Manage Groups', 
		'url'=>array('admin'),
		'linkOptions'=>array('id'=>'group_admin_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin
	),
);
?>

<h1>Update Group <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>