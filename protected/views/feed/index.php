<?php
/**
 *
 **/
$this->pageTitle = 'Recent Activity';
?>
<?php echo PHtml::beginContentHeader(); ?>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

<div class="novel">
	<section id="feed">
		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view',
		)); ?>
	</section>
</div>