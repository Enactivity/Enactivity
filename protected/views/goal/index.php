<?php
	$this->pageTitle = 'Goals';
?>
<!--
<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
-->

<?php 
// "what would you want to do input" box
echo $this->renderPartial('_form', array('model'=>$model));
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>