<?php
$this->pageTitle = "Create GroupBanter";

$this->menu = MenuDefinitions::groupBanterMenu();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>