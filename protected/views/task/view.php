<?
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

<?= PHtml::beginContentHeader(array('class'=>PHtml::taskClass($model) )); ?>
	<h1><?= PHtml::encode($this->pageTitle); ?></h1>
	<span class="task-header-time"><? $this->widget('application.components.widgets.TaskDates', array('task'=>$model)); ?></span>
	<div class="menu toolbox">
		<ul>
			<li>
				<?=
				PHtml::link(
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
			<li>
				<?=
				PHtml::link(
					PHtml::encode('Timeline'), 
					array('task/feed', 'id'=>$model->id),
					array(
						'id'=>'task-feed-menu-item',
						'class'=>'neutral task-feed-menu-item',
						'title'=>'View recent history of this task',
					)
				);
				?>
			</li>
		</ul>
	</div>
<?= PHtml::endContentHeader(); ?>


<? // show participants
if($model->isParticipatable):
?>
<section id="participating">
	<h1><?= PHtml::encode(sizeof($model->participants)) . ' Signed Up'; ?></h1>
	<div class="menu controls">
		<ul>
			<? if($taskUser->canSignUp): ?>
			<li>
				<?= PHtml::button(
					"I'll do this", 
					array( //html
						'submit'=>array('task/signup', 'id'=>$model->id),
						'csrf'=>true,
						'id'=>'task-sign-up-menu-item-' . $model->id,
						'class'=>'positive task-sign-up-menu-item',
						'title'=>'Sign up for task',
					)
				); ?>
			</li>
			<? endif; ?>
			<? if($taskUser->canComplete): ?>
			<li>
				<?= PHtml::button(
					"I've done this",
					array( //html
						'submit'=>array('/task/complete', 'id'=>$model->id),
						'csrf'=>true,
						'id'=>'task-complete-menu-item-' . $model->id,
						'class'=>'positive task-complete-menu-item',
						'title'=>'Finish working on this task',
					)
				); ?>
			</li>
			<? endif; ?>
			<? if($taskUser->canResume): ?>
			<li>
				<?= PHtml::button(
					"I've got more to do",
					array( //html
						'submit'=>array('/task/resume', 'id'=>$model->id),
						'csrf'=>true,
						'id'=>'task-resume-menu-item-' . $model->id,
						'class'=>'neutral task-resume-menu-item',
						'title'=>'Resume work on this task',
					)
				); ?>
			</li>
			<? endif; ?>
			<? if($taskUser->canQuit): ?>
			<li>
				<?= PHtml::button(
					"Quit", 
					array( //html
						'submit' => array('task/quit', 'id'=>$model->id),
						'csrf' => true,
						'id'=>'task-quit-menu-item-' . $model->id,
						'class'=>'neutral task-quit-menu-item',
						'title'=>'Quit this task',
					)
				); ?>
			</li>
			<? endif; ?>
			<? if($taskUser->canIgnore): ?>
			<li>
				<?= PHtml::button(
					"Ignore", 
					array( //html
						'submit'=>array('task/ignore', 'id'=>$model->id),
						'csrf'=>true,
						'id'=>'task-ignore-menu-item-' . $model->id,
						'class'=>'neutral task-ignore-menu-item',
						'title'=>'Ignore this task',
					)
				); ?>
			</li>
			<? endif; ?>
		</ul>
	</div>
	<? foreach($model->participatingTaskUsers as $usertask) {
		echo $this->renderPartial('/taskuser/_view', array(
			'data'=>$usertask,
		));
	} ?>
</section>
<? endif; ?>

<? // show comments ?>
<section id="comments">
	<h1><?= 'Comments'; ?></h1>
	
	<?
	if($commentsDataProvider->totalItemCount > 0) :
		// show list of comments
		$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$commentsDataProvider,
			'itemView'=>'/comment/_view',
			'emptyText'=>''
		)); 
	else: ?>
	<p class="blurb">No one has written any comments yet, be the first!</p>
	<? endif; ?>
	
	
	<? // show new comment form ?>
	<?= $this->renderPartial('/comment/_form', array('model'=>$comment)); ?>
</section>