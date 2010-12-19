<?php
$this->pageTitle = $model->name . ' - ' . Yii::app()->name;
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Invite a User', 
		'url'=>array('group/invite'),
		'linkOptions'=>array('id'=>'group_invite_menu_item'),
	),
	array('label'=>'Update This Group', 
		'url'=>array('group/updateprofile','id'=>$model->id),
		'linkOptions'=>array('id'=>'group_profile_menu_item'),
	),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php 
//FIXME: redirect to group profile page
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'groupProfile.description:ntext',	
		'permalink:url',
	),
)); 
?>

<!-- List of users in group -->
<?php if(!Yii::app()->user->isGuest):?>
<div id="users">
	<h2>
		<?php echo $activemembers->getTotalItemCount() . ' Active Members'; ?>
	</h2>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$activemembers,
		'itemView'=>'/user/_users',
		'cssFile'=>false,
	)); 
	?>
</div>
<?php endif; ?>