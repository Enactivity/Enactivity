<?
/**
 * @uses $model 
 * @uses $feedDataProvider
 */
$this->pageTitle = 'Timeline for ' . $model->name;
?>

<header class="content-header">
	<nav class="menu">
		<ul>
			<li>
				<?= PHtml::link(
					PHtml::encode($model->name), 
					array('activity/view', 'id'=>$model->id),
					array(
						'id'=>'activity-view-menu-item',
						'class'=>'neutral activity-view-menu-item',
						'title'=>'View recent history of this activity',
					)
				); ?>
			</li>	
		</ul>
	</nav>
</header>

<section class="content">
	<? $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$feedDataProvider,
		'itemView'=>'/feed/_view',
	));?>
</section>