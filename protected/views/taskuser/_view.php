<? 
/**
 * @uses $data User model
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"user-" . PHtml::encode($data->id),
		'class'=>PHtml::taskUserClass($data),
	),
)); ?>
	<? $story->beginStoryContent(); ?>
		<? $this->widget('application.components.widgets.UserLink', array(
			'userModel' => $data->user,
		)); ?>
	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>