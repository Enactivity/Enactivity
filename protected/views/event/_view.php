<div class="view">

	<strong><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</strong>
	<?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>
	<br />

	<strong><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</strong>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<strong><?php echo CHtml::encode($data->getAttributeLabel('creatorId')); ?>:</strong>
	<?php echo CHtml::encode($data->creator->fullName()); ?>
	<br />

	<strong><?php echo CHtml::encode($data->getAttributeLabel('groupId')); ?>:</strong>
	<?php echo CHtml::encode($data->group->name); ?>
	<br />

	<strong><?php echo CHtml::encode($data->getAttributeLabel('starts')); ?>:</strong>
	<?php echo CHtml::encode($data->starts); ?>
	<br />

	<strong><?php echo CHtml::encode($data->getAttributeLabel('ends')); ?>:</strong>
	<?php echo CHtml::encode($data->ends); ?>
	<br />

	<strong><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</strong>
	<?php echo CHtml::encode($data->location); ?>
	<br />

</div>