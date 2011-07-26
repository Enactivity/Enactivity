<?php
$this->pageTitle = 'Our apologies';
?>

<header>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
</header>
<div class="error"><p><?php 
	echo PHtml::encode("Sorry, you've run into an unexpected error. The Poncla team's been notified and will work hard to make sure it doesn't happen again."); 
?></p></div>