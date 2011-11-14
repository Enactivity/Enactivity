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
	<div class="menu toolbox">
		<ul>
			<li>
				<?php
				echo PHtml::link(
					PHtml::encode('Edit'), 
					array('task/update', 'id'=>$model->id),
					array(
						'id'=>'task-update-menu-item-' . $model->id,
						'class'=>'neutral task-update-menu-item',
						'title'=>'Edit this task',
					)
				);
				?>
			</li>
		</ul>
	</div>

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
	<span class="task-header-time"><?php $this->widget('application.components.widgets.TaskDates', array('task'=>$model)); ?></span>
<?php echo PHtml::endContentHeader(); ?>

<div class="novel">
<?php
// show participants
if($model->isParticipatable):
?>
<section id="users-participating" class="novel">
	<div class="menu novel-controls">
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
			</ul>
		</div>
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

<?php if($model->isSubtaskable): ?>
<section id="agenda">
	<?php if($subtasks->totalItemCount > 0) :
	echo $this->renderPartial('_agenda', array(
			'datedTasks'=>$subtasks,
			'datelessTasks'=>$subtasks,
			'showParent'=>false,
	));
	else: ?>
	<p class="blurb">Since no one has signed up for this task yet, you can break it down into more specific tasks below.</p>
	<?php endif; ?>
	
	<?php echo $this->renderPartial('_form', array('model'=>$newTask, 'inline'=>true)); ?>
</section>
<?php endif; ?>
</div>

<?php // show comments ?>
<div class="novel">
	<section id="task-comments">
		<h1><?php echo 'Comments'; ?></h1>
		
		<?php
		if($commentsDataProvider->totalItemCount > 0) :
			// show list of comments
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$commentsDataProvider,
				'itemView'=>'/comment/_view',
				'emptyText'=>''
			)); 
		else: ?>
		<p class="blurb">No one has written any comments yet, be the first!</p>
		<?php endif; ?>
		
		
		<?php // show new comment form ?>
		<?php echo $this->renderPartial('/comment/_form', array('model'=>$comment)); ?>
	</section>
	
	<?php // Show history ?>
	<section id="task-activity">
		<h1><?php echo 'Recent Activity'; ?></h1>
		
		<?php 
		$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$feedDataProvider,
			'itemView'=>'/feed/_view',
		));?>
	</section>	
</div>