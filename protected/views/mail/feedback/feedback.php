<? 
/**
* View to display the feedback message
*/
?>
<article class="email">
	<p><strong><time><?= Yii::app()->format->formatDateTime(time()); ?></time></strong></p>
	<p>Full Name: <?=PHtml::encode($feedbackForm->fullName); ?></p>
	<p>Email: <?=PHtml::encode($feedbackForm->email); ?></p>
	<p>User ID: <?=PHtml::encode($feedbackForm->userId); ?></p>
	<p>Message: <?= PHtml::encode($feedbackForm->message); ?></p>
</article>