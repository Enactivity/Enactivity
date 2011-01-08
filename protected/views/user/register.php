<?php
$this->pageTitle = 'Register';
$this->menu = MenuDefinitions::userMenu();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>