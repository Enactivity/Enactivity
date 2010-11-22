<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Admin: List Users', 
		'url'=>array('index'),
		'linkOptions'=>array('id'=>'user_index_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

<p>
You may optionally enter a comparison operator (<strong>&lt;</strong>, <strong>&lt;=</strong>, <strong>&gt;</strong>, <strong>&gt;=</strong>, <strong>&lt;&gt;</strong>
or <strong>=</strong>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'username',
		'email',
		'firstName',
		'lastName',
		'status',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
