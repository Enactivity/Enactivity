<?php
$this->pageTitle = 'Manage Feed';

$this->menu = MenuDefinitions::adminMenu();

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('active-record-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php echo PHtml::beginContentHeader(); ?>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

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
	'id'=>'active-record-log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'model',
		'modelId',
		'action',
		'modelAttribute',
		'userId',
		/*
		'created',
		'modified',
		*/
// 		array(
// 			'class'=>'CButtonColumn',
// 		),
	),
)); ?>
