<? 
$this->pageTitle = 'Edit Task';
?>

<?= PHtml::beginContentHeader(); ?>
	<div class="menu toolbox">
		<ul>
	<?
	echo PHtml::openTag('li');
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
	}
	echo PHtml::closeTag('li');
	?>
	</ul>
	</div>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<div class="novel">
	<section>
		<?= $this->renderPartial('_form', array('model'=>$model)); ?>
	</section>
</div>