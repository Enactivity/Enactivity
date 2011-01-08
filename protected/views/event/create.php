<?php
$this->pageTitle = 'Create an Event';

$this->menu = MenuDefinitions::eventMenu();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>