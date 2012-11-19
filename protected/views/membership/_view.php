<? 
/**
 * View for individual group models
 * 
 * @uses membership $data model
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"membership-" . PHtml::encode($data->group->id),
		'class'=>PHtml::groupClass($data->group),
	),
));?>
	<? $story->beginStoryContent(); ?>
		<h1 class="story-title">
			<?= PHtml::encode($data->group->name); ?>
			<span class="status">
				<? if($data->isActive): ?>
				Active
				<? endif; ?>
				<? if($data->isInactive): ?>
				Inactive
				<? endif; ?>
			</span>
		</h1>
		<? $story->beginControls(); ?>
			<li>
				<? if($data->isActive): ?>
				<?= PHtml::button(
					PHtml::encode('Deactivate'),
					array( //html
						'submit'=>array('membership/leave', 'id'=>$data->id),
						'csrf'=>true,
						'id'=>'membership-leave-menu-item-' . $data->id,
						'class'=>'neutral membership-leave-menu-item',
						'title'=>'Stop using this group with ' . Yii::app()->name,
					)
				); ?>
				<? endif; ?>
				<? if($data->isInactive): ?>
				<?= PHtml::button(
					PHtml::encode('Activate'),
					array( //html
						'submit'=>array('membership/join', 'id'=>$data->id),
						'csrf'=>true,
						'id'=>'membership-join-menu-item-' . $data->id,
						'class'=>'positive membership-join-menu-item',
						'title'=>'Start using this group with ' . Yii::app()->name,
					)
				); ?>
				<? endif; ?>
				<? if($data->isDeactivated): ?>
				<p>Rejoin this group on Facebook to use it with <?= Yii::app()->name ?></p>
				<? endif; ?>
			</li>
		<? $story->endControls(); ?>

	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>