<?php
$this->pageTitle = 'Groups';

?>

<header>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
</header>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'cssFile'=>false,
)); ?>
