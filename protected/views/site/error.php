<?
/**
 * @uses $error Error message
 */
$this->pageTitle = PHtml::encode($error['code'] . ' Error'); 
?>

<section class="error content">
	<p>
		<? if(isset($error['message']) && strcasecmp($error['type'], 'CHttpException') == 0): ?>
			<?= PHtml::encode($error['message']); ?>
		<? else: ?>
			<?= PHtml::encode("Sorry, you've run into an unexpected error. The " . Yii::app()->name . " team's been notified and will work hard to make sure it doesn't happen again."); ?>
		<? endif; ?>
	</p>
</section>