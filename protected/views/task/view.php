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

	<h1>
	<? if(sizeof($ancestors) > 0): ?>
	<? foreach($ancestors as $task) {
		echo PHtml::link(
			PHtml::encode($task->name),
			array('task/view', 'id'=>$task->id)
		);
		echo ': ';
	} ?>
	<? endif; ?>
	<?= PHtml::encode($this->pageTitle); ?></h1>
	<span class="task-header-time"><? $this->widget('application.components.widgets.TaskDates', array('task'=>$model)); ?></span>
<?= PHtml::endContentHeader(); ?>


<? // show participants
if($model->isParticipatable):
?>
<section id="participating">
	<h1><?= PHtml::encode(sizeof($model->participants)) . ' Signed Up'; ?></h1>
	<div class="menu controls">
	<ul>
	<?
	if($model->isParticipatable) {
		// show complete/uncomplete buttons if user is participating
		if($model->isUserParticipating) {
			?>
				<li>
				<?
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
					
					<?
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
	<? 
	foreach($model->participatingTaskUsers as $usertask) {
		echo $this->renderPartial('/taskuser/_view', array(
			'data'=>$usertask,
		));
	}
	?>
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