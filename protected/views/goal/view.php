<?php
	#$this->pageTitle = 'View Goal ' . $model->id;
	$this->pageTitle = $model->name;
	
	$this->pageMenu = MenuDefinitions::goalMenu($model);
?>
<!-- 
<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
-->

<?php 
// "what would you want to do input" box
echo $this->renderPartial('_form', array('model'=>new Goal(Goal::SCENARIO_INSERT)));
?>

<p>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'groupId',
		'ownerId',
		'isCompleted',
		'isTrash',
		'created',
		'modified',
	),
)); ?>
</p>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$taskDataProvider,
	'itemView'=>'/task/_view',
)); ?>

