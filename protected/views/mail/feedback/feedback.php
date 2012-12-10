<? 
/**
* View to display the feedback message
*/
?>
<article class="email">
	<p><strong><time><?= Yii::app()->format->formatDateTime(time()); ?></time></strong></p>
	<p>From: <?=PHtml::encode($this->email); ?></p>
	<p>Message: <?= PHtml::encode($this->message); ?></p>
</article>