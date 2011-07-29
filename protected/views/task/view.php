<?php
$this->pageTitle = $model->name;
?>

<header>
	<h1>


	<?php
	if(!$model->isRoot()) {
		echo PHtml::openTag('span', array('class'=>'parent-task-name'));
		echo PHtml::link(
			PHtml::encode($model->parent->name),
			array('task/view', 'id'=>$model->parent->id)
		);
		echo PHtml::closeTag('span');
		echo ' ';
	}
	echo PHtml::encode($this->pageTitle);
	?></h1>
	<p>

	<?php $this->widget('application.components.widgets.TaskDates', array('task'=>$model)); ?></p>
</header>

<menu class="toolbox">
	<ul>



	<?php
	if($model->isParticipatable) {
		// show complete/uncomplete buttons if user is participating
		if($model->isUserParticipating) { ?>
		<li>
		<?php
		if($model->isUserComplete) {
			echo PHtml::link(
			PHtml::encode('Resume'),
			array('/task/useruncomplete', 'id'=>$model->id),
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
			echo PHtml::link(
			PHtml::encode('Complete'),
			array('/task/usercomplete', 'id'=>$model->id),
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
		echo PHtml::link(
			PHtml::encode('Quit'), 
			array('task/unparticipate', 'id'=>$model->id),
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
		echo PHtml::link(
			PHtml::encode('Sign up'), 
			array('task/participate', 'id'=>$model->id),
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
			echo PHtml::link(
				PHtml::encode('Update'), 
				array('task/update', 'id'=>$model->id),
				array(
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
	echo PHtml::link(
		PHtml::encode('Restore'), 
		array('task/untrash', 'id'=>$model->id),
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
	echo PHtml::link(
		PHtml::encode('Trash'), 
		array('task/trash', 'id'=>$model->id),
		array( //html
			'submit'=>array('task/trash', 'id'=>$model->id),
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
</menu>


<?php
// show participants
if($model->isParticipatable):
?>
<section id="users-participating">
	<header>
		<h1>
			
		<?php echo PHtml::encode(sizeof($model->participants)) . ' Signed Up'; ?></h1>
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
		'month'=>$month,
		'showParent'=>false,
));
?>
</section>

<?php endif; ?>

<?php // "what would you want to do input" box
if($model->isSubtaskable) {
	echo $this->renderPartial('_form', array('model'=>$newTask));
}

// Show history
?>
<section>
	<header>
		<h1><?php echo 'Recent Activity'; ?></h1>
	</header>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$feedDataProvider,
		'itemView'=>'/feed/_view',
	));
	?>
	
</section>
