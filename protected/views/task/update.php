<header class="content-header">
	<nav class="content-header-nav">
		<ul>
			<li>
				<?= PHtml::link(
					"<i></i> " . PHtml::encode($model->name),
					$model->viewUrl,
					array(
						'id'=>'task-view-menu-item-' . $model->id,
						'class'=>'neutral task-view-menu-item',
						'title'=>'View this ' . PHtml::encode($model->name),
				)); ?>
			</li>
		</ul>
	</nav>
</header>

<section class="content">
	<?= $this->renderPartial('_form', array('model'=>$model)); ?>
</section>