<? 
/**
 * View for individual group models
 * 
 * @uses GroupUser $data model
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"membership-" . PHtml::encode($data->group->id),
		'class'=>PHtml::groupClass($data->group),
	),
));?>
	<? $story->beginStoryContent(); ?>
		<h1 class="story-title">
			<? if($data->isActive): ?>
			<?= PHtml::link(PHtml::encode($data->group->name), 
				array('group/view', 'id'=>$data->group->id)
			); ?>
			<? else:  ?>
			<span><?= PHtml::encode($data->group->name); ?></span>
			<? endif; ?>
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
							'title'=>'Stop using this group with Poncla',
					)
				); ?>
				<? else: ?>
				<?= PHtml::button(
					PHtml::encode('Activate'),
					array( //html
							'submit'=>array('membership/join', 'id'=>$data->id),
							'csrf'=>true,
							'id'=>'membership-join-menu-item-' . $data->id,
							'class'=>'positive membership-join-menu-item',
							'title'=>'Start using this group with Poncla',
					)
				); ?>
				<? endif; ?>
			</li>
		<? $story->endControls(); ?>

	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>