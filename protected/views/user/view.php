<?php
$this->pageTitle = $model->fullName;
?>

<header>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
</header>
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'email:email',
	),
)); ?>
