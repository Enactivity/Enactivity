<?php
$this->pageTitle = StringUtils::truncate($model->content, 60);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>