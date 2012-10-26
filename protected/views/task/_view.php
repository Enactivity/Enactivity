<? 
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

	<? $story->beginStoryContent(); ?>
		<? // task name ?>
		<time>
			<?= PHtml::encode(Yii::app()->format->formatTime($data->starts)); ?>
		</time>
		<h1>
			<?= PHtml::link(
				PHtml::encode($data->name), 
				array('/task/view', 'id'=>$data->id)
			); ?>
		</h1>

<!-- 		<span class="comment-count">
			<?= PHtml::link(
				PHtml::tag('span', array(), PHtml::encode($data->commentCount)) . " Comments",
				array('/task/view', 'id'=>$data->id, '#' => 'comments')
			); ?>
		</span>
		<span class="participant-count">
			<?= PHtml::link(
				PHtml::tag('span', array(), PHtml::encode($data->participantsCount)) . " Signed Up",
				array('/task/view', 'id'=>$data->id, '#' => 'participating')
			); ?>
		</span>
		<span class="participant-completed-count">
			<?= PHtml::link(
				PHtml::tag('span', array(), PHtml::encode($data->participantsCompletedCount)) . " Completed",
				array('/task/view', 'id'=>$data->id, '#' => 'participating')
			); ?>
		</span>
 -->
		
<!-- 		<? $story->beginControls(); ?>
			<? if($data->isParticipatable) {
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
		<? $story->endControls() ?> -->
	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>