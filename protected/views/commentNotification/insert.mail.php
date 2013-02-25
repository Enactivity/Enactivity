<? 
/**
 * View for taskcomment model insert scenario
 * 
 */
?>
<article class="view email">
	<p>
		<strong><time><?= PHtml::encode(
			//FIXME: use actual event time
			Yii::app()->format->formatDateTime(time())
		); ?></time></strong>
	</p>
	<p><? PHtml::e($user->fullName); ?> just left a comment for
		<?= PHtml::link(PHtml::encode($data->modelObject->name), 
			$data->modelObject->viewUrl
			); ?>.</p>
	<blockquote>
		<?= Yii::app()->format->formatStyledText($data->content); ?>
	</blockquote>
</article>