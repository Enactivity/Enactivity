<?
/**
 * 
 * @uses $model
 */

$this->pageTitle = 'Update Order';
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<div class="novel">
	<section>
		<?= $this->renderPartial('/cartItem/_form', array('model'=>$model)); ?>
	</section>
</div>