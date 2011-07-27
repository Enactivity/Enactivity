<?php
$this->pageTitle = Yii::app()->format->formatMonth($month->timestamp) . " " . $month->year;
$this->menu[] = array(
	'label'=>'Previous Month', 
	'url'=>array('task/calendar',
		'month' => $month->intValue - 1 < 1 ? 12 : $month->intValue - 1,
		'year' => $month->intValue - 1 < 1 ? $month->year - 1 : $month->year,
	),
	'linkOptions'=>array('id'=>'task_next_month_menu_item'),
);

$this->menu[] = array(
	'label'=>'Next Month', 
	'url'=>array('task/calendar',
		'month' => $month->intValue + 1 > 12 ? 1 : $month->intValue + 1,
		'year' => $month->intValue + 1 > 12 ? $month->year + 1 : $month->year,
	),
	'linkOptions'=>array('id'=>'task_next_month_menu_item'),
);
?>



<header>
	<h1><?php echo PHtml::encode($this->pageTitle); ?></h1>
</header>

<?php 
// show task calendar
echo $this->renderPartial('_calendar', array(
	'dataProvider'=>$dataProvider,
	'month'=>$month,
));
?>

<?php
// "what would you want to do input" box
echo $this->renderPartial('_form', array('model'=>$newTask));

for($day = 1; $day <= $month->calendarDays; $day++) {
	$currentDayStart = mktime(0, 0, 0, $month->intValue, $day, $month->year);
	$currentDayEnd = mktime(23, 59, 59, $month->intValue, $day, $month->year);
	
	$htmlId = 'day-' . $day;
	echo PHtml::openTag('h1', array('id' => $htmlId));
	echo Yii::app()->format->formatDate($currentDayStart);
	echo PHtml::closeTag('h1');
	
	foreach($dataProvider->getData() as $task) {
		if((PDateTime::MySQLDateOffset($task->starts) <= $currentDayEnd)
		&& (PDateTime::MySQLDateOffset($task->starts) >= $currentDayStart)) {
			$this->renderPartial('_view', array('data'=>$task));
		}
	}
	
}
