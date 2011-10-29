<?php
$this->pageTitle = 'What\'s Next';
?>

<?php echo PHtml::beginContentHeader(); ?>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

<?php
// "what would you want to do input" box
echo $this->renderPartial('_form', array('model'=>$model));

foreach ($tasks as $task) {
	$this->renderPartial('/task/_view', array('data'=>$task));
}