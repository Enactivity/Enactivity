<article class="view">
<dl>
	<dt><p><?php 
		echo CFormatter::formatNtext($data->content); 
	?></p></dt>
	
	<dd><span><?php $this->widget('ext.widgets.UserLink', array(
		'userModel' => $data->creator,
	)); ?></span></dd>

	<dd><span><?php echo CHtml::encode(Yii::app()
		->dateformatter
		->formatDateTime($data->created, 'full', 'short')); 
	?></span></dd>
	
	<?php if($model->modified != $model->created): ?>
	<dd><span><b><?php 
		echo CHtml::encode($data->getAttributeLabel('modified')); 
	?>:</b>
	<?php echo CHtml::encode(Yii::app()
		->dateformatter
		->formatDateTime($data->modified, 'full', 'short')); ?></span></dd>
	<?php endif; ?>
</dl>
</article>