
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('cart-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Manage Carts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'cart-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'user.firstName',
		'user.lastName',
// 		'user.email',
// 		'user.phoneNumber',
//         'sweater_type',
//         'sweater_color',
//         'letter_color',
//         'letter_thread_color',
        'letters',
//         'extra_small_count',
//         'small_count',
//         'medium_count',
//         'large_count',
//         'extra_large_count',
//         'extra_extra_large_count',
        'isPlaced',
        'isDelivered',
        'created',
//         'modified',
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>