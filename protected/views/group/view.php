<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Invite a User', 'url'=>array('invite')),
	array('label'=>'Admin: Create a Group', 'url'=>array('create')),
	array('label'=>'Admin: Update This Group', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Admin: Delete This Group', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Admin: Manage Groups', 'url'=>array('admin')),
);
?>

<h1>Viewing <?php echo $model->name; ?></h1>

<?php 
//FIXME: redirect to group profile page
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'slug',
		'created',
		'modified',
	),
)); 
?>

<!-- List of users in group -->
<div id="users">
	<h3>
		<?php echo $activemembers->getTotalItemCount() . ' Active Members'; ?>
	</h3>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$activemembers,
		'itemView'=>'_users',
	)); 
	?>
</div>