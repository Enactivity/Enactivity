<?php
/* @var $this ActivityController */
/* @var $model Activity */
?>

<header class="content-header">
	<nav class="content-header-nav">
		<ul>
			<li>
			<?
				if($model->isTrash) {
				echo PHtml::button(
					PHtml::encode('Restore'),
					array( //html
							'submit'=>array('activity/untrash', 'id'=>$model->id),
							'csrf'=>true,
							'id'=>'activity-untrash-menu-item-' . $model->id,
							'class'=>'positive activity-untrash-menu-item',
							'title'=>'Restore this activity',
					)
				);
				}
				else {
				echo PHtml::button(
				PHtml::encode('Trash'),
					array( //html
							'submit'=>array('activity/trash', 'id'=>$model->id),
							'csrf'=>true,
							'id'=>'activity-trash-menu-item-' . $model->id,
							'class'=>'neutral activity-trash-menu-item',
							'title'=>'Trash this activity',
					)
				);
				} ?>
			</li>
		</ul>
	</nav>
</header>

<section class="content">
	<?= $this->renderPartial('_form', array('model'=>$model)); ?>
</section>