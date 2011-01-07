<div class="view">
	<h2><?php 
		echo CHtml::link(StringUtils::truncate(CHtml::encode($data->content), 80), 
			array('groupbanter/view', 'id'=>$data->id)); 
	?></h2>
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('creatorId')); ?>:</b>
	<?php echo CHtml::encode($data->creator->fullName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('groupId')); ?>:</b>
	<?php echo CHtml::encode($data->group->name); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('repliesCount')); ?>:</b>
	<?php echo CHtml::encode($data->repliesCount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($data->modified); ?>
	<br />

</div>