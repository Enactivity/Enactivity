<?php
/**
 * @uses $model 
 * @uses $subtasks
 * @uses $newTask
 * @uses $feedDataProvider
 */
$this->pageTitle = $model->name;
?>

<header>
	<h1>
	<?php
	if(!$model->isRoot()) {
		echo PHtml::openTag('span', array('class'=>'parent-task-name'));
		echo PHtml::link(
			StringUtils::truncate(PHtml::encode($model->parent->name)),
			array('task/view', 'id'=>$model->parent->id)
		);
		echo PHtml::closeTag('span');
		echo ' ';
	}
	echo PHtml::encode($this->pageTitle);
	?>
	</h1>
	<p>
		<?php $this->widget('application.components.widgets.TaskDates', array('task'=>$model)); ?>
	</p>
</header>

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
						'class'=>'task-useruncomplete-menu-item',
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
						'class'=>'task-usercomplete-menu-item',
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
					'class'=>'task-unparticipate-menu-item',
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
					'class'=>'task-participate-menu-item',
					'title'=>'Sign up for task',
				)
			);
			echo PHtml::closeTag('li');
		}
	}
	?>
		<li>
			<?php
			echo PHtml::button(
				PHtml::encode('Update'), 
				array(
					'submit'=>array('task/update', 'id'=>$model->id),
					'csrf'=>true,
					'id'=>'task-update-menu-item-' . $model->id,
					'class'=>'task-update-menu-item',
					'title'=>'Update this task',
				)
			);
			?>
		</li>
<?php
echo PHtml::openTag('li');
if($model->isTrash) {
	echo PHtml::button(
		PHtml::encode('Restore'), 
		array( //html
			'submit'=>array('task/untrash', 'id'=>$model->id),
			'csrf'=>true,
			'id'=>'task-untrash-menu-item-' . $model->id,
			'class'=>'task-untrash-menu-item',
			'title'=>'Restore this task',
		)
	);
}
else {
	echo PHtml::button(
		PHtml::encode('Trash'), 
		array( //html
			'submit'=>array('task/delete', 'id'=>$model->id),
			'csrf'=>true,
			'id'=>'task-trash-menu-item-' . $model->id,
			'class'=>'task-trash-menu-item',
			'title'=>'Trash this task',
		)
	);
}
echo PHtml::closeTag('li');
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
	foreach($model->participants as $user) {
		echo $this->renderPartial('/user/_view', array(
			'data'=>$user,
		));
	}
	?>
</section>

<?php endif; ?>

<?php
// Show children tasks
if($model->isSubtaskable):
?>
<section id="child-tasks">
<?php
echo $this->renderPartial('_agenda', array(
		'datedTasks'=>$subtasks,
		'datelessTasks'=>$subtasks,
		'showParent'=>false,
));
?>
</section>

<?php endif; ?>

<?php // "what would you want to do input" box
if($model->isSubtaskable) {
	echo $this->renderPartial('_form', array('model'=>$newTask, 'inline'=>true));
}

// Show history
?>
<section>
	<h1><?php echo 'Recent Activity'; ?></h1>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$feedDataProvider,
		'itemView'=>'/feed/_view',
	));
	?>
	
</section>
