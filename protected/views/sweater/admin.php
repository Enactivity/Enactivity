<?
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sweater-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Sweaters</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?= CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<? $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<? $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sweater-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'style',
		'clothColor',
		'letterColor',
		'stitchingColor',
		'size',
		/*
		'available',
		'created',
		'modified',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
