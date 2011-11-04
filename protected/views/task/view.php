<?php
/**
 * @uses $model 
 * @uses $subtasks
 * @uses $ancestors
 * @uses $newTask
 * @user $comment
 * @uses $commentsDataProvider
 * @uses $feedDataProvider
 */
$this->pageTitle = $model->name;
?>

<?php echo PHtml::beginContentHeader(); ?>
	<? if(sizeof($ancestors) > 0): ?>
	<nav class="breadcrumb"><p>
	<?php foreach($ancestors as $task) {
		echo PHtml::link(
			StringUtils::truncate(PHtml::encode($task->name), 15, "") . '&hellip;',
			array('task/view', 'id'=>$task->id)
		);
	} ?>
	</p></nav>
	<?php endif; ?>
	<h1><?php echo PHtml::encode($this->pageTitle); ?></h1>
	<p>
		<?php $this->widget('application.components.widgets.TaskDates', array('task'=>$model)); ?>
	</p>
<?php echo PHtml::endContentHeader(); ?>

<div class="menu toolbox">
	<ul>
	<?php
	if($model->isParticipatable) {
		// show complete/uncomplete buttons if user is participating
		if($model->isUserParticipating) { 
	?>
		<li>
		<?php
			if($model->isUserComplete) {
				echo PHtml::button(
					PHtml::encode('Resume'),
					array( //html
						'submit'=>array('/task/useruncomplete', 'id'=>$model->id),
						'csrf'=>true,
						'id'=>'task-useruncomplete-menu-item-' . $model->id,
						'class'=>'neutral task-useruncomplete-menu-item',
						'title'=>'Resume work on this task',
					)
				);
			}
			else {
				echo PHtml::button(
					PHtml::encode('Complete'),
					array( //html
						'submit'=>array('/task/usercomplete', 'id'=>$model->id),
						'csrf'=>true,
						'id'=>'task-usercomplete-menu-item-' . $model->id,
						'class'=>'positive task-usercomplete-menu-item',
						'title'=>'Finish working on this task',
					)
				);
			}
			?>
			</li>
			
			<?php
			// 'participate' button
			echo PHtml::openTag('li');
			echo PHtml::button(
				PHtml::encode('Quit'), 
				array( //html
					'submit' => array('task/unparticipate', 'id'=>$model->id),
					'csrf' => true,
					'id'=>'task-unparticipate-menu-item-' . $model->id,
					'class'=>'neutral task-unparticipate-menu-item',
					'title'=>'Quit this task',
				)
			);
			echo PHtml::closeTag('li');
		}
		else {
			echo PHtml::openTag('li');
			echo PHtml::button(
				PHtml::encode('Sign up'), 
				array( //html
					'submit'=>array('task/participate', 'id'=>$model->id),
					'csrf'=>true,
					'id'=>'task-participate-menu-item-' . $model->id,
					'class'=>'positive task-participate-menu-item',
					'title'=>'Sign up for task',
				)
			);
			echo PHtml::closeTag('li');
		}
	}
	?>
		<li>
			<?php
			echo PHtml::link(
				PHtml::encode('Update'), 
				array('task/update', 'id'=>$model->id),
				array(
					'id'=>'task-update-menu-item-' . $model->id,
					'class'=>'neutral task-update-menu-item',
					'title'=>'Update this task',
				)
			);
			?>
		</li>
<?php
?>
</ul>
</div>


<?php
// show participants
if($model->isParticipatable):
?>
<section id="users-participating">
	<h1><?php echo PHtml::encode(sizeof($model->participants)) . ' Signed Up'; ?></h1>
	<?php 
	foreach($model->participatingTaskUsers as $usertask) {
		echo $this->renderPartial('/taskuser/_view', array(
			'data'=>$usertask,
		));
	}
	?>
</section>
<?php endif; ?>

<?php if($model->isSubtaskable):?>
<section id="child-tasks">
	<?php
	echo $this->renderPartial('_agenda', array(
			'datedTasks'=>$subtasks,
			'datelessTasks'=>$subtasks,
			'showParent'=>false,
	));
	?>
	<?php echo $this->renderPartial('_form', array('model'=>$newTask, 'inline'=>true)); ?>
</section>
<?php endif; ?>

<?php // show comments ?>
<section id="task-comments">
<h1><?php echo 'Comments'; ?></h1>
	
	<?php 
	// show list of comments
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$commentsDataProvider,
		'itemView'=>'/comment/_view',
		'emptyText'=>''
	));
	
	// show new comment form ?>
	<?php echo $this->renderPartial('/comment/_form', array('model'=>$comment)); ?>
</section>

<?php
// Show history
?>
<section id="task-activity">
	<h1><?php echo 'Recent Activity'; ?></h1>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$feedDataProvider,
		'itemView'=>'/feed/_view',
	));
	?>
	
</section>
