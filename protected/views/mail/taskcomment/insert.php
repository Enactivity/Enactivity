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
	<p>Yo! <? PHtml::e($user->fullName); ?> just left a comment for <?= PHtml::link(PHtml::encode($data->getModelObject()->name), PHtml::taskURL($data->getModelObject())); ?>.</p>
	<blockquote>
		<?= Yii::app()->format->formatStyledText($data->content); ?>
	</blockquote>
</article>