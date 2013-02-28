<article>
	<p>
		<strong><time><?= PHtml::encode(
			//FIXME: use actual event time
			Yii::app()->format->formatDateTime(time())
		); ?></time></strong>
	</p>
	<p><?= PHtml::link(PHtml::encode($activity->name), $activity->viewUrl); ?> 
		was published with <?= PHtml::encode($activity->taskCount); ?> tasks.
	</p>
	<blockquote>
		<?= Yii::app()->format->formatStyledText($activity->description); ?>
	</blockquote>
</article>