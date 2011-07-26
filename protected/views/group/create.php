<?php
$this->pageTitle = 'Create a Group';

$this->menu = MenuDefinitions::adminMenu();
?>

<header>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
</header>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>