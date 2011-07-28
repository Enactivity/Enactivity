<?php
$this->pageTitle = 'Tasks';
?>

<header>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
</header>

<?php
// "what would you want to do input" box
echo $this->renderPartial('_form', array('model'=>$newTask));

echo $this->renderPartial('_agenda', array('tasks'=>$dataProvider->data));
