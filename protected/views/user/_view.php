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

<?php $this->widget('application.components.widgets.UserLink', array(
			'userModel' => $data,
)); ?>

<?php $this->endWidget(); ?>