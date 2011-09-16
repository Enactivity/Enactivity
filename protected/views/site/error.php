<?php
/**
 * @uses $error Error message
 */
$this->pageTitle = PHtml::encode($error['code'] . ' Error'); 
?>

<header>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
</header>
<div class="error"><p><?php
	if(isset($error['message']) && strcasecmp($error['type'], 'CHttpException') == 0) {
		echo PHtml::encode($error['message']); 
	}
	else {
		echo PHtml::encode("Sorry, you've run into an unexpected error. The Poncla team's been notified and will work hard to make sure it doesn't happen again.");
	}
?></p></div>