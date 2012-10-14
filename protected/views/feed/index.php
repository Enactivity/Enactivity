<?
/**
 *
 **/
$this->pageTitle = 'Timeline';
?>
<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<section id="feed">
	<? $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
</section>