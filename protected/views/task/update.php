<? 
$this->pageTitle = 'Edit Task';
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
	<div class="content-header-nav">
		<ul>
			<li>
			<?
				if($model->isTrash) {
				echo PHtml::button(
					PHtml::encode('Restore'),
					array( //html
							'submit'=>array('task/untrash', 'id'=>$model->id),
							'csrf'=>true,
							'id'=>'task-untrash-menu-item-' . $model->id,
							'class'=>'positive task-untrash-menu-item',
							'title'=>'Restore this task',
					)
				);
				}
				else {
				echo PHtml::button(
				PHtml::encode('Trash'),
					array( //html
							'submit'=>array('task/trash', 'id'=>$model->id),
							'csrf'=>true,
							'id'=>'task-trash-menu-item-' . $model->id,
							'class'=>'neutral task-trash-menu-item',
							'title'=>'Trash this task',
					)
				);
				} ?>
			</li>
		</ul>
	</div>
<?= PHtml::endContentHeader(); ?>

<section>
	<?= $this->renderPartial('_form', array('model'=>$model)); ?>
</section>