<?php
/**
 * Lists user's upcoming tasks
 * @uses datedTasksProvider
 * @uses datelessTasksProvider
 * @uses newTask
 */

$this->pageTitle = 'Home';
?>

<?php echo PHtml::beginContentHeader(); ?>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

<div class="novel">
	<section class="tasks">
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
		<h1><?php echo 'Start a New Task'; ?></h1>
		<?php echo $this->renderPartial('_form', array('model'=>$newTask, 'inline'=>true)); ?>
	</section>
</div>

<div class="novel">
<?php // Show history ?>
	<section id="feed">
		<h1><?php echo 'Recent Activity'; ?></h1>
		<?php 
		$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$feedProvider,
			'itemView'=>'/feed/_view',
		));?>
	</section>	
</div>