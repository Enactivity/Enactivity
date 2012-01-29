<?php 
$this->pageTitle = 'Edit Task';
?>

<?php echo PHtml::beginContentHeader(); ?>
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
				'submit'=>array('task/delete', 'id'=>$model->id),
				'csrf'=>true,
				'id'=>'task-trash-menu-item-' . $model->id,
				'class'=>'negative task-trash-menu-item',
				'title'=>'Trash this task',
				'confirm'=>'Are you sure?  It will be gone forever.',
		)
		);
	}
	echo PHtml::closeTag('li');
	?>
	</ul>
	</div>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

<div class="novel">
	<section>
		<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	</section>
</div>