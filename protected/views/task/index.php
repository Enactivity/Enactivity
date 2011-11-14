<?php
/**
 * Lists user's upcoming tasks
 * @uses datedTasksProvider
 * @uses datelessTasksProvider
 * @uses newTask
 */

$this->pageTitle = 'Tasks';
?>

<?php echo PHtml::beginContentHeader(); ?>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

<section class="novel">
	<?php
	if($datedTasksProvider->itemCount > 0
	|| $datelessTasksProvider->itemCount > 0) {
		echo $this->renderPartial('_agenda', array(
			'datedTasks'=>$datedTasksProvider->data,
			'datelessTasks'=>$datelessTasksProvider->data,
			'showParent'=>true,
		));
	}
	else {
		//TODO: make more user-friendly
		echo PHtml::openTag('p', array('class'=>'no-results-message blurb'));
		echo 'You haven\'t signed up for any tasks.  Why not check out the ';
		echo PHtml::link('calendar', array('task/calendar'));
		echo ' to see what is listed or ';
		echo PHtml::link('start a new task', array('task/index', '#'=>'task-form'));
		echo '?'; 
		echo PHtml::closeTag('p');
	}
	
	// "what would you want to do input" box ?>
	<?php echo $this->renderPartial('_form', array('model'=>$newTask, 'inline'=>true)); ?>
</section>