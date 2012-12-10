<? 
/**
* View to display the feedback message
*/
?>
<article class="email">
	<p><strong><time><?= Yii::app()->format->formatDateTime(time()); ?></time></strong></p>
	<p>From: <?=PHtml::encode($feedbackForm->email); ?></p>
	<p>Message: <?= PHtml::encode($feedbackForm->message); ?></p>
</article>