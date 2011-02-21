<article class="view">
<dl>
	<dt>
	<?php 
	$description = isset($data->modelObject) ? $data->modelObject->feedAttribute : $data->model;

	?>
	<?php $this->widget('ext.widgets.UserLink', array(
		'userModel' => $data->user,
	)); ?> <?php echo strtolower($data->action); ?>
	<?php echo CHtml::link(CHtml::encode($description), array(strtolower($data->model) . '/view', 'id'=>$data->modelId)); ?>
	</dt>
	<dd><span><?php echo PHtml::encode(Yii::app()->dateformatter->formatDateTime($data->created, 
		'full', 'short')); ?></span></dd>
</dl>
</article>