<? 
/**
 * @uses $data User model
 */
?>
<article id="response-<?= PHtml::encode($data->id); ?>" class="<?= PHtml::responseClass($data); ?>">
	<div class="avatar response-avatar">
		<?= PHtml::image($data->user->pictureUrl); ?>
	</div>
	<div class="response-body">
		<header>
			<h1>
				<? $this->widget('application.components.widgets.UserLink', array(
				'userModel' => $data->user,
			)); ?>
			</h1>
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
		</header>
	</div>
</article>