<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creatorId')); ?>:</b>
	<?php echo CHtml::encode($data->creatorId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('groupId')); ?>:</b>
	<?php echo CHtml::encode($data->groupId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('starts')); ?>:</b>
	<?php echo CHtml::encode($data->starts); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ends')); ?>:</b>
	<?php echo CHtml::encode($data->ends); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($data->location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($data->modified); ?>
	<br />

	*/ ?>

</div>