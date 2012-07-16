<?
?>

<h1>View CartItem #<?= $model->id; ?></h1>

<? $this->widget('zii.widgets.CDetailView', array(
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
