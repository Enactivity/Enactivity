<?php
/* @var $this ActivityController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Activities';
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<section class="activities">
	<? foreach($activities as $activity): ?>
	<? $this->renderPartial('_view', array('data'=>$activity)); ?>
	<? endforeach; ?>
</section>