<article class="view">
<dl>
	<dt><p><?php 
		echo  Yii::app()->format->formatStyledText($data->content); 
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
<?php if($data->creatorId == Yii::app()->user->id):?>
<footer>
	<dd><span><?php 
		echo CHtml::link('Update', array('eventbanter/update', 'id' => $data->id) ); ?></span></dd>
	<dd><span><?php 
		echo CHtml::link('Delete', 
			'#',
			array(
				'confirm'=>'Are you sure you want to delete this item?',
				'csrf' => true,
				'id'=>'event_banter_delete_banter_item_' . $data->id, //unique id required or last instance is deleted
				'submit' => array(
					'eventbanter/delete',
					'id'=>$data->id,
				),
			)
		); ?></span></dd>
</footer>
<?php endif; ?>
</article>