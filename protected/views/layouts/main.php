<!doctype html> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>  
		<!-- Add "maximum-scale=1" to fix the weird iOS auto-zoom bug on orientation changes. -->

		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<? Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/stylesheets/screen.css"); ?>

		<? Yii::app()->clientScript->registerCoreScript('jquery'); ?>
		<? Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/main.js"); ?>

		<link rel="shortcut icon" href="<?= Yii::app()->request->baseUrl; ?>/images/favicon.ico"/>
		<link rel="apple-touch-icon" href="<?= Yii::app()->theme->baseUrl; ?>/images/application-cutout-logo-60x60.png">
	    <link rel="apple-touch-icon" sizes="72x72" href="<?= Yii::app()->theme->baseUrl; ?>/images/favicon-72x72.png">
	    <link rel="apple-touch-icon" sizes="114x114" href="<?= Yii::app()->theme->baseUrl; ?>/images/favicon-114x114.png"> 

		<title><?= CHtml::encode($this->pageTitle) . ' - ' . Yii::app()->name; ?></title>
		
	<? 
	// Include Google Analytics widget
	$this->widget('ext.analytics.AnalyticsWidget', array()); 
	?>
			
	</head>
	<body id="<?= $this->id . '-' . $this->action->id; ?>">

		<header class="application-header" id="application-header">
			<a href="/" >Enactivity</a>
			<a id="show-menu" href="#application-navigation">Menu</a>
		</header>
		
		<!-- flash notices -->
		<? if(Yii::app()->user->hasFlash('error')):?>
		<aside class="flash flash-error">
			<span><?= Yii::app()->user->getFlash('error'); ?></span>
		</aside>
		<? endif; ?>
		<? if(Yii::app()->user->hasFlash('notice')):?>
		<aside class="flash flash-notice">
			<span><?= Yii::app()->user->getFlash('notice'); ?></span>
		</aside>
		<? endif; ?>
		<? if(Yii::app()->user->hasFlash('success')):?>
		<aside class="flash flash-success">
			<span><?= Yii::app()->user->getFlash('success'); ?></span>
		</aside>
		<? endif; ?>

		<?= $content; ?>

		<nav class="application-navigation" id="application-navigation">
			<? $this->widget('zii.widgets.CMenu', array(
				'encodeLabel'=>false,
				'items'=>MenuDefinitions::applicationMenu()
			));?>
		</nav>

		<footer class="application-footer">
			<p class="copyright"><?= PHtml::link(Yii::app()->name, "http://twitter.com/#!/Enactivity"); ?> &copy; <?= date('Y'); ?> 
				All Rights Reserved.
			</p>
			<p class="credits">Created by 
				<?= PHtml::link("Reed Musselman", "http://twitter.com/#!/blue21japan"); ?>, 
				<?= PHtml::link("Andy Fong", "http://twitter.com/#!/andysfong"); ?>, 
				<?= PHtml::link("Harrison Vuong", "http://twitter.com/#!/harrisonvuong"); ?>, and 
				<?= PHtml::link("Ajay Sharma", "http://twitter.com/#!/ajsharma"); ?>.
				<!-- Also, chicken wings and beer, lots of beer. --> 
			</p>

			<? if(Yii::app()->user->isAuthenticated): ?>
			<p class="logout">
				<?= PHtml::link("Logout", '/site/logout'); ?>
			<? endif; ?>
		</footer>
	</body>
</html>