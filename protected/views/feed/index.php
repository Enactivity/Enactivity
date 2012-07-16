<?
/**
 *
 **/
$this->pageTitle = 'Recent Activity';
?>
<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<div class="novel">
	<section id="feed">
		<? $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view',
		)); ?>
	</section>
</div>