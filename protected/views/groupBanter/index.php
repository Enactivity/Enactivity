<?php
$this->pageTitle = 'Banter';

$this->menu = MenuDefinitions::groupBanterMenu();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
