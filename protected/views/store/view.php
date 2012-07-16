
<?
?>

<h1>View Cart #<?= $model->id; ?></h1>

<? $this->widget('zii.widgets.CDetailView', 
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
            'sweaterLetters',
            'quantity',
            'purchased',
            'delivered',
            'created',
            'modified',
        ),
    )
); ?>