<div class="view">
	<h2><?php 
		echo CHtml::link(StringUtils::truncate(CHtml::encode($data->content), 80), 
			array('groupbanter/view', 'id'=>$data->id)); 
	?></h2>
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('creatorId')); ?>:</b>
	<?php echo CHtml::encode($data->creator->fullName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode(Yii::app()->dateformatter->formatDateTime($data->created, 
		'full', 'short')); ?>
	<br />
	
	<?php if($model->modified != $model->created): ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode(Yii::app()->dateformatter->formatDateTime($data->modified, 
		'full', 'short')); ?>
	<br />
	<?php endif; ?>

</div>