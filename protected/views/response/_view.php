<? 
/**
 * @uses $data User model
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"user-" . PHtml::encode($data->id),
		'class'=>PHtml::responseClass($data),
	),
)); ?>
	<? $story->beginAvatar(); ?>
		<?= PHtml::image($data->user->pictureUrl); ?>
	<? $story->endAvatar(); ?>
	<h1>
		<? $this->widget('application.components.widgets.UserLink', array(
		'userModel' => $data->user,
	)); ?>
	<span class="status">
		<? if($data->isSignedUp): ?>
		Hasn't started
		<? endif; ?>
		<? if($data->isStarted): ?>
		In progress
		<? endif; ?>
		<? if($data->isCompleted): ?>
		Completed
		<? endif; ?>
	</span>
	</h1>
<? $this->endWidget(); ?>