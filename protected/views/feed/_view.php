<article class="view">
<dl>
	<dt><?php //on create ?>
	<?php $this->widget('ext.widgets.UserLink', array(
		'userModel' => $data->user,
	)); ?> <?php echo strtolower($data->action); ?>d 
	<?php echo CHtml::link(CHtml::encode($data->model), array(strtolower($data->model) . '/view', 'id'=>$data->modelId)); ?>
	</dt>
	<dd><span><?php echo PHtml::encode(Yii::app()->dateformatter->formatDateTime($data->created, 
		'full', 'short')); ?></span></dd>
</dl>
</article>