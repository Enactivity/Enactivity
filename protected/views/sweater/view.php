<?
?>

<h1>View Sweater #<?= $model->id; ?></h1>

<? $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'style',
		'clothColor',
		'letterColor',
		'stitchingColor',
		'size',
	),
)); ?>
