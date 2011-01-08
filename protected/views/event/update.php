<?php
$this->pageTitle = $model->name;

$this->menu = MenuDefinitions::eventMenu($model->id);

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>