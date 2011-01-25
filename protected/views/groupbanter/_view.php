<article class="view">
<dl>
	<dt><h2><?php 
		echo PHtml::link(StringUtils::truncate(PHtml::encode($data->content), 80), 
			array('groupbanter/view', 'id'=>$data->id)); 
	?></h2></dt>
	
	<dd><span><?php $this->widget('ext.widgets.UserLink', array(
		'userModel' => $data->creator,
	)); ?></span></dd>

	<dd><span><?php echo PHtml::encode(Yii::app()->dateformatter->formatDateTime($data->created, 
		'full', 'short')); ?></span></dd>
	
	<?php if($model->modified != $model->created): ?>
	<dd><span><b><?php echo PHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo PHtml::encode(Yii::app()->dateformatter->formatDateTime($data->modified, 
		'full', 'short')); ?></span></dd>
	<?php endif; ?>
</dl>
</article>