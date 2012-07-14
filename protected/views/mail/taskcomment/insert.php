<?php 
/**
 * View for taskcomment model insert scenario
 * 
 */
?>
<article class="view email">
	<p>
		<strong><time><?php echo PHtml::encode(
			//FIXME: use actual event time
			Yii::app()->format->formatDateTime(time())
		); ?></time></strong>
	</p>
	<p>Yo! <?php PHtml::e($user->fullName); ?> just left a comment for <?php echo PHtml::link(PHtml::encode($data->getModelObject()->name), PHtml::taskURL($data->getModelObject())); ?>.</p>
	<blockquote><p><?php PHtml::e($data->content); ?></p></blockquote>
</article>