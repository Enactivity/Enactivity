<? 
$this->pageTitle = 'Admin Access'; 
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<section class="tasks">
	<? 
	$this->widget('zii.widgets.CMenu', array(
		'items'=>MenuDefinitions::adminMenu()
	)); 
	?>
</section>