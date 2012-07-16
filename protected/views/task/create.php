<? 
$this->pageTitle = 'Create a New Task';
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>
<div class="novel">
	<section>
		<?= $this->renderPartial('_form', array('model'=>$model)); ?>
	</section>
</div>