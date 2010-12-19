<?php
$this->pageTitle = 'Create a Group';

$this->menu=array(
	array('label'=>'Invite a User', 
		'url'=>array('invite'),
		'linkOptions'=>array('id'=>'group_invite_menu_item'),
	),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>