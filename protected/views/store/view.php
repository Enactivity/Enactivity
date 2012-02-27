
<?php
?>

<h1>View Cart #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'user.firstName',
		'user.lastName',
		'user.email',
		'user.phoneNumber',
        'sweater_type',
        'sweater_color',
        'letter_color',
        'letter_thread_color',
        'letters',
        'extra_small_count',
        'small_count',
        'medium_count',
        'large_count',
        'extra_large_count',
        'extra_extra_large_count',
        'isPlaced',
        'isDelivered',
        'created',
        'modified',
    ),
)); ?>