<?php
$this->pageTitle = $model->name;
?>

<?php echo PHtml::beginContentHeader(); ?>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>