<?php
/* @var $this ActivityController */
/* @var $model Activity */

$this->pageTitle = 'Create a New Activity';
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<section>
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</section>