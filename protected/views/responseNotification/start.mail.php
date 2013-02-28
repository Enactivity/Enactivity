<article class="view email">
	<p>
		<strong><time><?= PHtml::encode(
			//FIXME: use actual event time
			Yii::app()->format->formatDateTime(time())
		); ?></time></strong>
	</p>
	<p><?= PHtml::encode($user->fullName); ?> 
		<?= PHtml::encode($response->getScenarioLabel()); ?>
		<?= PHtml::link(PHtml::encode($task->name), $task->viewUrl); ?>.
	</p>
</article>