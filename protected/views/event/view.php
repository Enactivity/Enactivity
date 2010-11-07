<?php
$this->breadcrumbs=array(
	'Events'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Event', 'url'=>array('index')),
	array('label'=>'Create Event', 'url'=>array('create')),
	array('label'=>'Update Event', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Event', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Event', 'url'=>array('admin')),
);
?>

<h1>View Event #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'creatorId',
		'groupId',
		'starts',
		'ends',
		'location',
		'created',
		'modified',
	),
)); 

?>

<?php 
//RSVP buttons
$this->renderPartial('_rsvp', array(
	'eventuser'=>$eventuser,
)); 
?>

<!-- List of users in event -->
<div id="users">
	<h3>
		<?php echo $model->eventUsersAttendingCount . ' Attending'; ?>
	</h3>
 
        <?php $this->renderPartial('_eventusers', array(
            'group'=>$model,
            'eventUsers'=>$model->eventUsersAttending,
        )); ?>
</div>