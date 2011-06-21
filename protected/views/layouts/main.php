<!doctype html> 
<html>
<head>
	<meta charset="utf-8">
	<!-- Add "maximum-scale=1" to fix the weird iOS auto-zoom bug on orientation changes. -->
	<meta name="viewport" content="width=device-width; initial-scale=1"/>  

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="all" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="all" />
	<![endif]-->

	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico"/> 

	<title><?php echo CHtml::encode($this->pageTitle) . ' - ' . Yii::app()->name; ?></title>
	
<?php 
// Include Google Analytics widget
$this->widget('ext.analytics.AnalyticsWidget', array()); 
?>
		
</head>
<body class="<?php echo $this->id . '-' . $this->action->id; ?>">

<div class="everything">
	<header>
		<nav id="primaryNavigation">
		<?php 
		$this->widget('zii.widgets.CMenu', array(
			'items'=>MenuDefinitions::globalMenu()
		)); 
		?>
		</nav><!-- end of primaryNavigation -->
	
		<?php
		if(isset($this->menu) 
			&& !empty($this->menu)
		):?>
		<nav id="secondaryNavigation">
		<?php 
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
		));
		?>
		</nav><!-- end of secondaryNavigation -->
		<?php endif; ?>
	</header>
	
	<section class="content">
		<?php echo $content; ?>
	</section>
	
</div>

<footer>
	<span>Poncla &copy; <?php echo date('Y'); ?> All Rights Reserved.</span>
	<nav>
	<?php 
	$this->widget('zii.widgets.CMenu', array(
		'items'=>MenuDefinitions::footer()
	)); 
	?>
	</nav>
</footer>

</body>
</html>