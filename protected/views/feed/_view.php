<article class="view">
<dl>
	<dt>
	<?php 
	// hack to make feed names clearer
	$description = '';
	if(isset($data->modelObject->name)) {
		$description = $data->modelObject->name;
	}
	elseif(isset($data->modelObject->description)) {
		$description = $data->modelObject->description;
	}
	elseif(isset($data->modelObject->content)) {
		$description = $data->modelObject->content;
	}
	else {
		$description = $data->model;
	}
	
	?>
	<?php $this->widget('ext.widgets.UserLink', array(
		'userModel' => $data->user,
	)); ?> <?php echo strtolower($data->action); ?>d 
	<?php echo CHtml::link(CHtml::encode($description), array(strtolower($data->model) . '/view', 'id'=>$data->modelId)); ?>
	</dt>
	<dd><span><?php echo PHtml::encode(Yii::app()->dateformatter->formatDateTime($data->created, 
		'full', 'short')); ?></span></dd>
</dl>
</article>