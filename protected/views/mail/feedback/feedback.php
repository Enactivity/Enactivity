<? 
/**
* View to display the feedback message
*/
?>
<article class="email">
	<p><strong><time><?= Yii::app()->format->formatDateTime(time()); ?></time></strong></p>
	<p>Full Name: <?=PHtml::encode($user->fullName); ?></p>
	<p>Email: <?=PHtml::encode($user->email); ?></p>
	<p>User ID: <?=PHtml::encode($user->id); ?></p>
	<p>Message: <?= PHtml::encode($feedbackForm->message); ?></p>
</article>