
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
        'sweaterType',
        'sweaterColor',
        'letterColor',
        'letterThreadColor',
        'letters',
        'extraSmallCount',
        'smallCount',
        'mediumCount',
        'largeCount',
        'extraLargeCount',
        'extraExtraLargeCount',
        'placed',
        'delivered',
        'created',
        'modified',
    ),
)); ?>