<?
/**
 * @uses $model 
 * @uses $feedDataProvider
 */
$this->pageTitle = $model->name;
?>

<?= PHtml::beginContentHeader(array('class'=>PHtml::taskClass($model) )); ?>
	<h1>Timeline for <?= PHtml::link(
		PHtml::encode($model->name), 
			array('task/view', 'id'=>$model->id),
			array(
				'id'=>'task-view-menu-item',
				'class'=>'neutral task-view-menu-item',
				'title'=>'View recent history of this task',
			)
		); ?>
	</h1>
<?= PHtml::endContentHeader(); ?>

<section id="task-activity">		
	<? 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$feedDataProvider,
		'itemView'=>'/feed/_view',
	));?>
</section>	