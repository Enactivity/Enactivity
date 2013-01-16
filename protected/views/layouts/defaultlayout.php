<? $this->beginLayout('//layouts/main'); ?>
<body>
	<div id="page-<?= $this->id . '-' . $this->action->id; ?>" class="page page-<?= $this->id . '-' . $this->action->id; ?> page-controller-<?= $this->id; ?> page-action-<?= $this->action->id; ?>">
		<header class="application-header" id="application-header">
			<div class="application-header-wrapper">
				<a href="/" class="logo">e</a>
				<a href="#" class="page-title"><?= PHtml::encode($this->pageTitle); ?></a>
				<a href="<?= PHtml::encode(Yii::app()->request->url); ?>" class="refresh" data-type="refresh-button"><i></i></a>
			</div>
		</header>
		
		<!-- flash notices -->
		<? if(Yii::app()->user->hasFlash('error')):?>
		<aside class="flash flash-error">
			<div>
				<span><?= PHtml::encode(Yii::app()->user->getFlash('error')); ?></span>
			</div>
		</aside>
		<? endif; ?>
		<? if(Yii::app()->user->hasFlash('notice')):?>
		<aside class="flash flash-notice">
			<div>
				<span><?= PHtml::encode(Yii::app()->user->getFlash('notice')); ?></span>
			</div>
		</aside>
		<? endif; ?>
		<? if(Yii::app()->user->hasFlash('success')):?>
		<aside class="flash flash-success">
			<div>
				<span><?= PHtml::encode(Yii::app()->user->getFlash('success')); ?></span>
			</div>
		</aside>
		<? endif; ?>

		<section id="application-content" class="application-content">
			<?= $content; ?>
		</section>

		<nav class="application-navigation" id="application-navigation">
			<? $this->widget('zii.widgets.CMenu', array(
				'encodeLabel'=>false,
				'items'=>MenuDefinitions::applicationMenu()
			));?>
		</nav>

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
	</div>
</body>
<? $this->endLayout(); ?>