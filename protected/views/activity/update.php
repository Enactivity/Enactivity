<?php
/* @var $this ActivityController */
/* @var $model Activity */
?>

<header class="content-header">
	<nav class="content-header-nav">
		<ul>
			<li>
				<?= PHtml::link(
					"<i></i> " . PHtml::encode($model->activity->name),
					$model->activity->viewUrl,
					array(
						'id'=>'activity-view-menu-item-' . $model->activity->id,
						'class'=>'neutral activity-view-menu-item',
						'title'=>'View this ' . PHtml::encode($model->activity->name),
				)); ?>
			</li>
		</ul>
	</nav>
</header>

<section class="content">
	<?= $this->renderPartial('/activityandtasks/_form', array(
		'model'=>$model,
	)); ?>
</section>