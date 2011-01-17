<?php
$this->pageTitle = StringUtils::truncate($model->content, 60);

$this->menu = MenuDefinitions::groupBanterMenu($model);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>