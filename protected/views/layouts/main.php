<!doctype html> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
		<meta name="<?= Yii::app()->request->csrfTokenName; ?>" content="<?= Yii::app()->request->csrfToken; ?>">
		<meta name="error-handler-url" content="<?= $this->logErrorUrl; ?>">

		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<? Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/stylesheets/screen.css"); ?>

		<? Yii::app()->clientScript->registerCoreScript('jquery'); ?>
		<? Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
		<? Yii::app()->clientScript->registerCoreScript('application'); ?>

		<link rel="shortcut icon" href="<?= Yii::app()->request->baseUrl; ?>/images/favicon.ico"/>
		<link rel="apple-touch-icon" href="<?= Yii::app()->theme->baseUrl; ?>/images/application-cutout-logo-60x60.png">
	    <link rel="apple-touch-icon" sizes="72x72" href="<?= Yii::app()->theme->baseUrl; ?>/images/favicon-72x72.png">
	    <link rel="apple-touch-icon" sizes="114x114" href="<?= Yii::app()->theme->baseUrl; ?>/images/favicon-114x114.png"> 

		<title><?= PHtml::encode($this->pageTitleWithBranding); ?></title>
		
	<? 
	// Include Google Analytics widget
	$this->widget('ext.analytics.AnalyticsWidget', array()); 
	?>
			
	<? if(Yii::app()->metrics->reportingEnabled): ?>
	<? Yii::app()->clientScript->registerCoreScript('metrics'); ?>
	<? endif; ?>

	</head>
	<?= $content; ?>
</html>