<article>
	<p>
		<strong><time><?= PHtml::encode(
			//FIXME: use actual event time
			Yii::app()->format->formatDateTime(time())
		); ?></time></strong>
	</p>
	<p><?= PHtml::link(PHtml::encode($data->name), $data->viewUrl); ?> was published with <?= PHtml::encode($data->taskCount); ?> tasks.</p>
	<blockquote>
		<?= Yii::app()->format->formatStyledText($data->description); ?>
	</blockquote>
</article>