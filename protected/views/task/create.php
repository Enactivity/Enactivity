<? 
$this->pageTitle = 'Create a New Task for ' . PHtml::encode($activity->name);
?>

<section class="content">
	<?= $this->renderPartial('/task/_form', array('model'=>$model)); ?>
</section>