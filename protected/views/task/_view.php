<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('/task/view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('goalId')); ?>:</b>
	<?php echo CHtml::encode($data->goalId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ownerId')); ?>:</b>
	<?php echo CHtml::encode($data->ownerId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('priority')); ?>:</b>
	<?php echo CHtml::encode($data->priority); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isCompleted')); ?>:</b>
	<?php echo CHtml::encode($data->isCompleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isTrash')); ?>:</b>
	<?php echo CHtml::encode($data->isTrash); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('starts')); ?>:</b>
	<?php echo CHtml::encode($data->starts); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ends')); ?>:</b>
	<?php echo CHtml::encode($data->ends); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($data->modified); ?>
	<br />	
	<br />


</div>