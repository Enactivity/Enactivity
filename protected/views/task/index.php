<?
/**
 * Lists user's upcoming tasks
 * @uses calendar
 * @uses newTask
 */

$this->pageTitle = 'Dashboard';
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<div class="novel">
	<section class="tasks">
		<?
		if($calendar->itemCount > 0) {
			echo $this->renderPartial('_agenda', array(
				'calendar'=>$calendar,
				'showParent'=>true,
			));
		}
		else {
			//TODO: make more user-friendly
			echo PHtml::openTag('p', array('class'=>'no-results-message blurb'));
			echo 'You haven\'t signed up for any tasks.  Why not check out the ';
			echo PHtml::link('calendar', array('task/calendar'));
			echo ' to see what is listed or ';
			echo PHtml::link('start a new task', '#task-form');
			echo '?'; 
			echo PHtml::closeTag('p');
		}
		
		// "what would you want to do input" box ?>
		<h1><?= 'Create a New Task'; ?></h1>
		<?= $this->renderPartial('_form', array(
			'model'=>$newTask, 
			'inline'=>true, 
			'action'=>'create')
		); ?>
	</section>
</div>

<div class="novel">
<? // Show history ?>
	<section id="feed">
		<h1><?= 'Recent Activity'; ?></h1>
		<? 
		$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$feedProvider,
			'itemView'=>'/feed/_view',
			'enablePagination'=>false,
		));?>
		<? if($feedProvider->totalItemCount > $feedProvider->pagination->pageSize): ?>
		<div class="pager">
			<ul>
				<li><?= PHtml::link('More recent activity', array('feed/index', 'ActiveRecordLog_page' => 2)); ?></li>
			<ul>
		</div>
		<? endif; ?>
	</section>	
</div>