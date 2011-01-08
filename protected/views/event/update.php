<?php
$this->pageTitle = $model->name;

$this->menu = MenuDefinitions::eventMenu($model);

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>