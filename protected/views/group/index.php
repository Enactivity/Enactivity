<?php
$this->pageTitle = 'Groups';

$this->menu=array(
	array('label'=>'Invite a User', 
		'url'=>array('group/invite'),
		'linkOptions'=>array('id'=>'group_invite_menu_item'),
	),
);
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'cssFile'=>false,
)); ?>
