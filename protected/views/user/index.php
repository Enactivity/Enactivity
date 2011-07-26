<?php
$this->pageTitle = 'Users';
?>

<header>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
</header>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_users',
	'cssFile'=>false,
)); ?>
