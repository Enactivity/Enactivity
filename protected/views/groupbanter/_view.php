<div class="view">
<dl>
	<dt><h2><?php 
		echo PHtml::link(StringUtils::truncate(PHtml::encode($data->content), 80), 
			array('groupbanter/view', 'id'=>$data->id)); 
	?></h2></dt>
	
	<dd><b><?php echo PHtml::encode($data->getAttributeLabel('creatorId')); ?>:</b>
	<?php $this->widget('ext.widgets.UserLink', array(
		'userModel' => $data->creator,
	)); 
	?></dd>

	<dd><b><?php echo PHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo PHtml::encode(Yii::app()->dateformatter->formatDateTime($data->created, 
		'full', 'short')); ?></dd>
	
	<?php if($model->modified != $model->created): ?>
	<dd><b><?php echo PHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo PHtml::encode(Yii::app()->dateformatter->formatDateTime($data->modified, 
		'full', 'short')); ?></dd>
	<?php endif; ?>
	
</dl>
</div>