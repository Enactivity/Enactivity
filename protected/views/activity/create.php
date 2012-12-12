<?php
/* @var $this ActivityController */
/* @var $model Activity */

$this->pageTitle = 'Create a New Activity';
?>

<section class="content">
	<?= $this->renderPartial('/activityandtasks/_form', array(
		'model'=>$model,
	)); ?>
</section>