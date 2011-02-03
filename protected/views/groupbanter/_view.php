<article class="view">
<dl>
	<dt><?php
		//truncate parentless banters
		if($data->parentId === null) { 
			echo '<h2>';
			echo PHtml::link(StringUtils::truncate(PHtml::encode($data->content), 80), 
			array('groupbanter/view', 'id'=>$data->id));
			echo '</h2>';	
		} 
		//if it has a parent, it's a reply, so show it all
		else {
			echo  Yii::app()->format->formatStyledText($data->content);
		}
	?></dt>
	
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

<?php if($data->creatorId == Yii::app()->user->id):?>
<footer>
<?php 
$this->widget('zii.widgets.CMenu', array(
	'items'=>array(
		array(
			'label'=>'Update', 
			'url'=>array('groupbanter/update', 'id' => $data->id),
			'linkOptions'=>array('class'=>'update_item'), 
		),
		array(
			'label'=>'Delete',
			'url'=>'#',
			'linkOptions'=>array(
				'class'=>'delete_item',
				'csrf' => true,
				'submit' => array(
					'groupbanter/delete',
					'id'=>$data->id,
				),
			),
		),
	)
));
?>
</footer>
<?php endif; ?>

</article>