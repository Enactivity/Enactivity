<?php
$this->pageTitle = $model->name;

$this->pageMenu = MenuDefinitions::eventMenu($model);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>