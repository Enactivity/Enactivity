<?php
/* @var $this ActivityController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Activities';
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<section class="activities agenda">
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
</section>