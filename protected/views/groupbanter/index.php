<?php
$this->pageTitle = 'Banter';

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'emptyText' => 'No one has posted anything yet.  What\'s on your mind?',
)); ?>
