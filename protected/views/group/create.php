<?php
$this->pageTitle = 'Create a Group';

$this->menu = MenuDefinitions::adminMenu();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>