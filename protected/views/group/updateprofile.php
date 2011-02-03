<?php
$this->pageTitle = $model->name;

$this->pageMenu = MenuDefinitions::groupMenu($model);
?>

<?php echo $this->renderPartial('_profileform', array('model'=>$model)); ?>