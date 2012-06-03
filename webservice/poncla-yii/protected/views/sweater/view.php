<?php
?>

<h1>View Sweater #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
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
