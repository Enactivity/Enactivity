
<?php
?>

<h1>View Cart #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', 
    array(
        'data'=>$model,
        'attributes'=>array(
            'id',
            'user.firstName',
        	'user.lastName',
        	'user.email',
        	'user.phoneNumber',
            'product.style',
            'product.clothColor',
            'product.letterColor',
            'product.stitchingColor',
            'product.size',
            'quantity',
            'purchased',
            'delivered',
            'created',
            'modified',
        ),
    )
); ?>