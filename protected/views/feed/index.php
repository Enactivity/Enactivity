<?php
$this->pageTitle = 'Recent Activity';
?>
<h1><?php echo PHtml::encode($this->pageTitle);?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
