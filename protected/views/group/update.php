<?php
$this->pageTitle = $model->name;

$this->pageMenu = MenuDefinitions::groupMenu($model);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>