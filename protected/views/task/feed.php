<?
/**
 * @uses $model 
 * @uses $feedDataProvider
 */
$this->pageTitle = $model->name;
?>

<?= PHtml::beginContentHeader(array('class'=>PHtml::taskClass($model) )); ?>
	<div class="menu toolbox">
		<ul>
			<li>
				<?=
				PHtml::link(
					PHtml::encode('View task'), 
					array('task/view', 'id'=>$model->id),
					array(
						'id'=>'task-view-menu-item',
						'class'=>'neutral task-view-menu-item',
						'title'=>'View recent history of this task',
					)
				);
				?>
			</li>
		</ul>
	</div>

	<h1>Timeline for 
	<?= PHtml::encode($this->pageTitle); ?></h1>
<?= PHtml::endContentHeader(); ?>

<section id="task-activity">		
	<? 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$feedDataProvider,
		'itemView'=>'/feed/_view',
	));?>
</section>	