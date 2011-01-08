<?php
$this->pageTitle = 'Manage GroupBanter';

$this->menu=array(
	array('label'=>'Manage Events', 
		'url'=>array('event/admin'), 
		'linkOptions'=>array('id'=>'event_admin_menu_item'),
		'visible'=>Yii::app()->user->isAdmin,
	),
	array('label'=>'Manage Users', 
		'url'=>array('user/admin'),
		'linkOptions'=>array('id'=>'user_admin_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Create Group', 
		'url'=>array('group/create'),
		'linkOptions'=>array('id'=>'group_create_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin
	),
	array('label'=>'Manage Groups', 
		'url'=>array('group/admin'), 
		'linkOptions'=>array('id'=>'group_manage_menu_item'),
		'visible'=>Yii::app()->user->isAdmin,
	),
	array('label'=>'Manage GroupBanter', 
		'url'=>array('groupbanter/admin'), 
		'linkOptions'=>array('id'=>'group_manage_menu_item'),
		'visible'=>Yii::app()->user->isAdmin,
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('group-banter-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'group-banter-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'creatorId',
		'groupId',
		'parentId',
		'content',
		'created',
		/*
		'modified',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
