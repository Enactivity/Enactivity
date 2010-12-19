<?php
$this->pageTitle = $model->name;

$this->menu=array(
	array('label'=>'Invite a User', 
		'url'=>array('group/invite'),
		'linkOptions'=>array('id'=>'group_invite_menu_item'),
	),
	array('label'=>'Update This Group', 
		'url'=>array('group/updateprofile'),
		'linkOptions'=>array('id'=>'group_profile_menu_item'),
	),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>