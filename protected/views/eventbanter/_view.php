<article class="view">
	<section><p><?php 
		echo CFormatter::formatNtext($data->content); 
	?></p></section>
	
	<footer>
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
	</footer>
</article>