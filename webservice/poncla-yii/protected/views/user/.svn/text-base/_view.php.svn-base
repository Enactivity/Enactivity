<?php 
/**
 * User model _view
 * @uses $data User model
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"user-" . PHtml::encode($data->id),
		'class'=>PHtml::userClass($data),
	),
)); ?>
	<?php $story->beginStoryContent(); ?>
		<?php $this->widget('application.components.widgets.UserLink', array(
					'userModel' => $data,
		)); ?>
	<?php $story->endStoryContent(); ?>
<?php $this->endWidget(); ?>