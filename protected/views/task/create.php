<? 
$this->pageTitle = 'Create a New Task for ' . PHtml::encode($activity->name);
?>

<?= PHtml::beginContentHeader(); ?>
	<h1>Create a New Task for <?= PHtml::link(
		PHtml::encode($activity->name),
			$activity->viewUrl,
			array(
				'class'=>'activity-name'
			)); ?></h1>
<?= PHtml::endContentHeader(); ?>

<section>
	<?= $this->renderPartial('/task/_form', array('model'=>$model)); ?>
</section>