<section class="greetings">
	<div class="inner">
		<h1><span class="big-e">E</span>nactivity</h1>

		<h2>A new way to organize activities with your group.</h2>

		<p>Enactivity makes it easy to plan activities that people 
			participate in, not just attend.</p>

		<a href="<?=Yii::app()->FB->loginUrl;?>" class="login">Sign in with Facebook, it's free <i></i></a>
	</div>
</section>

<section class="quotes">
	<div class="inner">
		<blockquote>
			<p>What a great app, everyone should be using it!</p>
			<p class="cite"><cite>say the guys who made Enactivity</cite></p>
		</blockquote>
	</div>
</section>

<section class="feature describe-responsive">
	<div class="inner">
		<h2><i></i> Works Everywhere</h2>
		<p>Enactivity's powerful web app works in all modern browsers, be they mobile devices, tablets, desktops, or laptops.</p>
		<p>If you've got an internet connection, you've got Enactivity.</p>
	</div>
</section>

<section class="feature describe-dashboard">
	<div class="inner">
		<h2><i></i> Simple Dashboard</h2>
		<p>Enactivity's dashboard shows the tasks you've signed up for and those still waiting for your response.</p>
		<p>Never fall behind again.</p>
	</div>
</section>

<section class="feature describe-calendar">
	<div class="inner">
		<h2><i></i> Calendar</h2>
		<p>All your groups' activities can be browsed at a glance on Enactivity's calendar.</p>
		<p>Stay organized.</p>
	</div>
</section>

<section class="feature describe-facebook">
	<div class="inner">
		<h2><i></i> Facebook Integration</h2>
		<p>Enactivity works with Facebook, your groups are automatically imported so you can start creating and sharing activities right away.</p>
		<p>Easy.</p>
	</div>
</section>

<footer class="application-footer">
	<div class="inner">
		<p class="copyright"><?= PHtml::link(Yii::app()->name, "http://facebook.com/EnactivityCommunity"); ?> &copy; <?= date('Y'); ?> 
			All Rights Reserved.
		</p>
		<p class="feedback"><?= PHtml::link("Talk to us on Facebook", "http://facebook.com/EnactivityCommunity"); ?>.</p>

		<? if(Yii::app()->user->isAuthenticated): ?>
		<p class="logout">
			<?= PHtml::link("Logout", '/site/logout'); ?>
		<? endif; ?>
	</div>
</footer>