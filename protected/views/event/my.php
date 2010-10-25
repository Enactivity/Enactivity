<?php
$this->breadcrumbs=array(
	'My Events',
);

$this->menu=array(
	array('label'=>'Create Event', 'url'=>array('create')),
	array('label'=>'Manage Event', 'url'=>array('admin')),
);
?>

<h1>My Events</h1>

<?php 
foreach($events as $event): ?>
	<b><?php echo CHtml::encode($event->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($event->id), array('view', 'id'=>$event->id)); ?>
	<br />

	<b><?php echo CHtml::encode($event->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($event->name); ?>
	<br />

	<b><?php echo CHtml::encode($event->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($event->description); ?>
	<br />

	<b><?php echo CHtml::encode($event->getAttributeLabel('creatorId')); ?>:</b>
	<?php echo CHtml::encode($event->creator->fullName()); ?>
	<br />

	<b><?php echo CHtml::encode($event->getAttributeLabel('groupId')); ?>:</b>
	<?php echo CHtml::encode($event->group->name); ?>
	<br />

	<b><?php echo CHtml::encode($event->getAttributeLabel('starts')); ?>:</b>
	<?php echo CHtml::encode($event->starts); ?>
	<br />

	<b><?php echo CHtml::encode($event->getAttributeLabel('ends')); ?>:</b>
	<?php echo CHtml::encode($event->ends); ?>
	<br />

	<b><?php echo CHtml::encode($event->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($event->location); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($event->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($event->created); ?>
	<br />

	<b><?php echo CHtml::encode($event->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($event->modified); ?>
	<br />

	*/ ?>
<?php endforeach; ?>
