<?php
?>

<h1>View CartItem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'userId',
		'productType',
		'productId',
		'quantity',
		'purchased',
		'delivered',
		'created',
		'modified',
	),
)); ?>
