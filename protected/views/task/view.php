<?php
$this->pageTitle = $model->name;
$this->pageMenu = MenuDefinitions::taskMenu($model);
if(isset($model->parentId)) {
	$this->pageMenu[] = array(
		'label'=>'Back Up', 
		'url'=>array('task/view', 'id'=>$model->parentId),
		'linkOptions'=>array('id'=>'task_parent_menu_item'),
	);
}

$this->widget('ext.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array( 
			'name' => 'starts',
			'type' => 'styledtext',
			'visible' => strlen($model->starts) > 0 ? true : false,
		),
		array( 
			'name' => 'ends',
			'type' => 'styledtext',
			'visible' => strlen($model->ends) > 0 ? true : false,
		),
	),
));


// show participants
?>
<section id="users-participating">
	<header>
		<h1><?php echo PHtml::encode(sizeof($model->participants)) . ' Signed Up'; ?></h1>
	</header>
	
	<?php 
	foreach($model->participants as $user) {
		echo PHtml::openTag('li');	
		$this->widget('ext.widgets.UserLink', array(
			'userModel' => $user,
		));
		echo PHtml::closeTag('li');
	}
	?>
</section>

<?php 
// Show children tasks
?>
<section id="child-tasks">
	<ol>
	<?php 
	foreach($model->children as $task) {
		echo PHtml::openTag('li');	
		$this->renderPartial('/task/_view', array('data'=>$task));
		echo PHtml::closeTag('li');
	}
	?>
	</ol>
</section>

<?php // "what would you want to do input" box
echo $this->renderPartial('_form', array('model'=>$newTask));

// Show history
?>
<section>
	<header>
		<h1><?php echo 'History'; ?></h1>
	</header>
	<?php 
	foreach($model->feed as $log) {
		$this->renderPartial('/feed/_feed',
			array(
				'data' => $log
			) 
		);
	}
	?>
</section>