<div class="view">

	<strong><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</strong>
	<?php echo CHtml::link(CHtml::encode($data->fullName()), array('view', 'id'=>$data->id)); ?>
	<br />

	<strong><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</strong>
	<?php echo CHtml::encode($data->email); ?>
	<br />

</div>