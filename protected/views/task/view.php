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

echo PHtml::openTag('p');
$this->widget('application.components.widgets.TaskDates', array(
	'task'=>$model,
));
echo PHtml::closeTag('p');

// show participants
?>
<section id="users-participating">
	<header>
		<h1><?php echo PHtml::encode(sizeof($model->participants)) . ' Signed Up'; ?></h1>
	</header>
	<?php 
	echo PHtml::openTag('ol', array('class' => 'users'));
	foreach($model->participants as $user) {
		echo PHtml::openTag('li');	
		$this->widget('application.components.widgets.UserLink', array(
			'userModel' => $user,
		));
		echo PHtml::closeTag('li');
	}
	echo PHtml::closeTag('ol');
	?>
</section>

<?php 
// Show children tasks
?>
<section id="child-tasks">
	<header>
		<h1><?php echo PHtml::encode(sizeof($model->children)) . ' Subtasks'; ?></h1>
	</header>
	<?php 
	foreach($model->children as $task) {
		$this->renderPartial('/task/_view', array('data'=>$task));
	}
	?>
</section>

<?php // "what would you want to do input" box
echo $this->renderPartial('_form', array('model'=>$newTask));

// Show history
?>
<section>
	<header>
		<h1><?php echo 'Recent Activity'; ?></h1>
	</header>
	<?php 
	foreach($model->feed as $log) {
		$this->renderPartial('/feed/_view',
			array(
				'data' => $log
			) 
		);
	}
	?>
</section>