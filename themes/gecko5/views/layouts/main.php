<!doctype html> 
<html>
<head>
	<meta charset="utf-8">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />

	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico"/> 

	<title><?php echo CHtml::encode($this->pageTitle) . ' - ' . Yii::app()->name; ?></title>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl() . '/js/libs/modernizr-1.6.min.js'); ?>	
</head>
<body>
<div class="bodycontainer" id="page">
<header>
<nav id="mainnav">
<?php 
$this->widget('zii.widgets.CMenu', array(
	'items'=>MenuDefinitions::mainMenu()
)); 
?>
</nav><!-- mainnav -->
		
<?php
if(isset($this->menu) 
	&& !empty($this->menu)
	&& !Yii::app()->user->isGuest
):?>
<nav id="subnav">
<?php 
$this->widget('zii.widgets.CMenu', array(
	'items'=>$this->menu,
));
?>
</nav><!-- end of subnav -->
<?php endif; ?>
	
<!-- flash notices -->
<?php if(Yii::app()->user->hasFlash('error')):?>
<div class="flash-error">
<?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('notice')):?>
<div class="flash-notice">
<?php echo Yii::app()->user->getFlash('notice'); ?>
</div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('success')):?>
<div class="flash-success">
<?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>
</header>
	
	<?php echo $content; ?>
	
</div><!-- page -->
	
<footer id="footer">
	<span>Poncla &copy; <?php echo date('Y'); ?> All Rights Reserved.</span>
</footer><!-- footer -->

</body>
</html>