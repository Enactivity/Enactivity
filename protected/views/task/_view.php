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
		
		<!-- <span class="comment-count">
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
		</span> -->

	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>