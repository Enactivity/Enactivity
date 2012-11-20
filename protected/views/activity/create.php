<?php
/* @var $this ActivityController */
/* @var $model Activity */

$this->pageTitle = 'Create a New Activity';
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<section>
	<?= $this->renderPartial('/activityandtasks/_form', array(
		'model'=>$model,
		'tasks'=>$tasks,
	)); ?>
</section>