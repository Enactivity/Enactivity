<?php
$this->pageTitle = 'Tasks';
?>

<header>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
</header>

<?php
// "what would you want to do input" box
echo $this->renderPartial('_form', array('model'=>$newTask));

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));