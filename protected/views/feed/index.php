<?
/**
 *
 **/
$this->pageTitle = 'Timeline';
?>

<section class="feed content">
	<? $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
</section>