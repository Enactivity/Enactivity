<?php 
/**
 * View for individual task models
 * 
 * @param Task $data model
 * @param boolean $showParent
 */

$showParent = isset($showParent) ? $showParent : true;

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"task-" . PHtml::encode($data->id),
		'class'=>PHtml::taskClass($data),
	),
)); ?>

	<?php $story->beginAvatar(); ?>
		<span class="time task-start-time"><?php echo PHtml::encode(Yii::app()->format->formatTime(strtotime($data->starts))); ?></span>
	<?php $story->endAvatar(); ?>
	
	<?php $story->beginStoryContent(); ?>
		<?php // task name ?>
		<h1 class="story-title">
			<?php if($showParent && !$data->isRoot()): ?>
			<span class="parent-tasks story-subtitle">
				<?php if($data->parent->id != $data->rootId): ?>
				<span class="parent-task-name top-parent-task-name">
					<?php echo PHtml::encode(StringUtils::truncate($data->root->name, 32)); ?>
				</span>
				<?php endif; ?>
				<span class="parent-task-name">
					<?php echo PHtml::encode(StringUtils::truncate($data->parent->name, 32)); ?>
				</span>
			</span>
			<?php endif; ?>
			<?php echo PHtml::link(
				PHtml::encode($data->name), 
				array('/task/view', 'id'=>$data->id)
			); ?>
		</h1>
		
		<?php $story->beginControls() ?>
			<?php if($data->isParticipatable) {
				// show complete/uncomplete buttons if user is participating
				if($data->isUserParticipating) {
					echo PHtml::openTag('li');
					
					if($data->isUserComplete) {
						echo PHtml::ajaxButton(
							PHtml::encode('Resume'), 
							array('/task/useruncomplete', 'id'=>$data->id, 'showParent'=>$showParent),
							array( //ajax
								'replace'=>'#task-' . $data->id,
								'type'=>'POST',
								'data'=>Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken,
							),
							array( //html
								'csrf' => true,
								'id'=>'task-useruncomplete-menu-item-' . $data->id,
								'class'=>'neutral task-useruncomplete-menu-item',
								'title'=>'Resume work on this task',
							)
						);
					}
					else {
						echo PHtml::ajaxButton(
							PHtml::encode('Complete'), 
							array('/task/usercomplete', 'id'=>$data->id, 'showParent'=>$showParent),
							array( //ajax
								'replace'=>'#task-' . $data->id,
								'type'=>'POST',
								'data'=>Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken,
							),
							array( //html
								'csrf' => true,
								'id'=>'task-usercomplete-menu-item-' . $data->id,
								'class'=>'positive task-usercomplete-menu-item',
								'title'=>'Finish working on this task',
							)
						); 
					}
					echo PHtml::closeTag('li');
					
					// 'participate' button
					echo PHtml::openTag('li');
					echo PHtml::ajaxButton(
						PHtml::encode('Quit'), 
						array('task/unparticipate', 'id'=>$data->id, 'showParent'=>$showParent),
						array( //ajax
							'replace'=>'#task-' . $data->id,
							'type'=>'POST',
							'data'=>Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->getCsrfToken(), 
						),
						array( //html
							'csrf' => true,
							'id'=>'task-unparticipate-menu-item-' . $data->id,
							'class'=>'neutral task-unparticipate-menu-item',
							'title'=>'Quit this task',
						)
					);
					echo PHtml::closeTag('li');
				}
				else {
					echo PHtml::openTag('li');
					echo PHtml::ajaxButton(
						PHtml::encode('Sign up'), 
						array('task/participate', 'id'=>$data->id, 'showParent'=>$showParent),
						array( //ajax
							'replace'=>'#task-' . $data->id,
							'type'=>'POST',
							'data'=>Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken,
						),
						array( //html
							'csrf'=>true,
							'id'=>'task-participate-menu-item-' . $data->id,
							'class'=>'positive task-participate-menu-item',
							'title'=>'Sign up for task',
						)
					);
					echo PHtml::closeTag('li');
				}
			} ?>
		<?php $story->endControls() ?>
	<?php $story->endStoryContent(); ?>
<?php $this->endWidget(); ?>