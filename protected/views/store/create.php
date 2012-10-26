<?
/**
 * 
 * @uses Cart $model
 */

$this->pageTitle = 'Build a Sweater';
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<section>
	<?= $this->renderPartial('/cartItem/_form', array('model'=>$model)); ?>
</section>