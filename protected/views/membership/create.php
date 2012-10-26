<?
$this->pageTitle = 'Create a Group';

$this->menu = MenuDefinitions::adminMenu();
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<section>
	<?= $this->renderPartial('_form', array('model'=>$model)); ?>
</section>