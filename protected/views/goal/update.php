<?php
	$this->pageTitle = 'Update Goal' . $model->id;
	
	$this->pageMenu = MenuDefinitions::goalMenu($model);
?>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>