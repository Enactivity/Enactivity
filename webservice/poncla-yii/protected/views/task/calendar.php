<?php
$this->pageTitle = Yii::app()->format->formatMonth($month->timestamp) . " " . $month->year;
?>

<?php echo PHtml::beginContentHeader(); ?>
<h1>Calendar</h1>
<?php echo PHtml::endContentHeader(); ?>

<div class="novel">
	<section id="calendar-container">
	<?php 
	// show task calendar
	echo $this->renderPartial('_calendar', array(
		'dataProvider'=>$datedTasksProvider,
		'month'=>$month,
	));
	?>
	</section>
</div>

<div class="novel">
	<section id="agenda-container" class="agenda">
		<?php
		// agenda
		echo $this->renderPartial('_agenda', array(
			'calendar'=>$calendar,
			'showParent'=>'true',
		));?>

		<h1><?php echo 'Start a New Task'; ?></h1>
		<?php echo $this->renderPartial('_form', array(
			'model'=>$newTask, 
			'inline'=>true, 
			'action'=>'create')
		); ?>
	</section>
</div>