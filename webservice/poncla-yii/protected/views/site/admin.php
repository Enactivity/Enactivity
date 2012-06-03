<?php 
$this->pageTitle = 'Admin Access'; 
?>

<?php echo PHtml::beginContentHeader(); ?>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

<div class="novel">
	<section class="tasks">
		<?php 
		$this->widget('zii.widgets.CMenu', array(
			'items'=>MenuDefinitions::adminMenu()
		)); 
		?>
	</section>
</div>