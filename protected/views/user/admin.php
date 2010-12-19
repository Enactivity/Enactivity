<?php
$this->pageTitle = 'Manage Users';

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
