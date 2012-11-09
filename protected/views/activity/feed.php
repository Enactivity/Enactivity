<?
/**
 * @uses $model 
 * @uses $feedDataProvider
 */
$this->pageTitle = $model->name;
?>

<?= PHtml::beginContentHeader(array('class'=>PHtml::activityClass($model) )); ?>
	<h1>Timeline for <?= PHtml::link(
		PHtml::encode($model->name), 
			array('activity/view', 'id'=>$model->id),
			array(
				'id'=>'activity-view-menu-item',
				'class'=>'neutral activity-view-menu-item',
				'title'=>'View recent history of this activity',
			)
		); ?>
	</h1>
<?= PHtml::endContentHeader(); ?>

<section id="activity-log">		
	<? 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$feedDataProvider,
		'itemView'=>'/feed/_view',
	));?>
</section>	