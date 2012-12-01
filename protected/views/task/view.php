<?
/**
 * @uses $model 
 * @uses $subtasks
 * @uses $ancestors
 * @uses $newTask
 * @user $comment
 * @uses $commentsDataProvider
 * @uses $feedDataProvider
 */
$this->pageTitle = $model->name . ' - ' . $model->activity->name;
?>

<?= PHtml::beginContentHeader(array('class'=>PHtml::taskClass($model) )); ?>
	<h1><?= PHtml::link(
		PHtml::encode($model->activity->shortName),
			$model->activity->viewUrl,
			array(
				'class'=>'activity-name'
			)); ?>: 
		<?= PHtml::encode($model->name); ?></h1>
	<span class="task-header-time"><i></i> <? $this->widget('application.components.widgets.TaskDates', array('task'=>$model)); ?></span>
	<div class="menu toolbox">
		<ul>
			<li>
				<?=
				PHtml::link(
					PHtml::encode('Edit'), 
					array('task/update', 'id'=>$model->id),
					array(
						'id'=>'task-update-menu-item-' . $model->id,
						'class'=>'neutral task-update-menu-item',
						'title'=>'Edit this task',
					)
				);
				?>
			</li>
			<li>
				<?=
				PHtml::link(
					PHtml::encode('Timeline'), 
					array('task/feed', 'id'=>$model->id),
					array(
						'id'=>'task-feed-menu-item',
						'class'=>'neutral task-feed-menu-item',
						'title'=>'View recent history of this task',
					)
				);
				?>
			</li>
		</ul>
	</div>
<?= PHtml::endContentHeader(); ?>

<section id="participating">
	<h1><?= PHtml::encode($model->participantsCount) . ' Signed Up'; ?></h1>
	<?= $this->renderPartial('/task/_controls', array(
		'model'=>$model,
		'response'=>$response,
	)); ?>
	<? foreach($model->participatingresponses as $usertask) {
		echo $this->renderPartial('/response/_view', array(
			'data'=>$usertask,
		));
	} ?>
</section>