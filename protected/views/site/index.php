<section class="greetings">
	<h1><span class="big-e">E</span>nactivity</h1>

	<p>Planning activities with your groups shouldn't be hard.</p>

	<a href="<?=Yii::app()->FB->loginUrl;?>" class="login">Sign in with Facebook <i></i></a>
	<span class="subtext">*it's free to get started now</span>
</section>

<section class="features">
	<div class="describe-responsive">
		<h2><i></i> Works Everywhere</h2>
		<p>Enactivity's powerful web app works in browsers everywhere.  If you've got an internet connection, you've got Enactivity.</p>
	</div>

	<div class="describe-dashboard">
		<h2><i></i> Simple Dashboard</h2>
		<p>Enactivity's dashboard shows the tasks you've signed up for and those still waiting for your response. Never fall behind again.</p>
	</div>

	<div class="describe-calendar">
		<h2><i></i> Calendar</h2>
		<p>Activities can easily be browsed on Enactivity's calendar.</p>
	</div>

	<div class="describe-facebook">
		<h2><i></i> Facebook Integration</h2>
		<p>Enactivity works with Facebook, your groups are automaticly imported so you can start creating and sharing activities right away.</p>
	</div>
</section>

<footer class="application-footer">
	<p class="feedbackButton"><?= PHtml::link("Give your feedback", "/site/feedback"); ?>.</p>
	<p class="copyright"><?= PHtml::link(Yii::app()->name, "http://facebook.com/EnactivityCommunity"); ?> &copy; <?= date('Y'); ?> 
		All Rights Reserved.
	</p>
	<p class="feedback"><?= PHtml::link("Talk to us on Facebook", "http://facebook.com/EnactivityCommunity"); ?>.</p>

	<? if(Yii::app()->user->isAuthenticated): ?>
	<p class="logout">
		<?= PHtml::link("Logout", '/site/logout'); ?>
	<? endif; ?>
</footer>