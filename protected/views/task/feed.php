<?
/**
 * @uses $model 
 * @uses $feedDataProvider
 */
$this->pageTitle = 'Timeline for ' . $model->name;
?>

<header class="content-header">
	<nav class="menu">
		<ol>
			<li><?= PHtml::link(
				PHtml::encode($model->name), 
					array('task/view', 'id'=>$model->id),
					array(
						'id'=>'task-view-menu-item',
						'class'=>'neutral task-view-menu-item',
						'title'=>'View ' . PHtml::encode($model->name),
					)
				); ?>
			</li>
		</ol>
	</nav>
<?= PHtml::endContentHeader(); ?>

<section id="task-log">		
	<? 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$feedDataProvider,
		'itemView'=>'/feed/_view',
	));?>
</section>	