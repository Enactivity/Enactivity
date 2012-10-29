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
	<? $story->beginAvatar(); ?>
		<?= PHtml::image($data->user->pictureUrl); ?>
	<? $story->endAvatar(); ?>
	<h1>
		<? $this->widget('application.components.widgets.UserLink', array(
		'userModel' => $data->user,
	)); ?>
	</h1>
<? $this->endWidget(); ?>