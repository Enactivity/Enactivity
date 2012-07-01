<?php 
/**
 * @uses $calendar
 * @uses $month
 */
?>

<?php 
// nav
$calendarMenu = array();
$calendarMenu[] = array(
	'label'=>'Previous', 
	'url'=>array('task/calendar',
		'month' => $month->monthIndex - 1 < 1 ? 12 : $month->monthIndex - 1,
		'year' => $month->monthIndex - 1 < 1 ? $month->year - 1 : $month->year,
	),
	'linkOptions'=>array(
		'id'=>'task-previous-month-menu-item',
		'class'=>'task-previous-month-menu-item',
	),
);

$calendarMenu[] = array(
	'label'=>'Next', 
	'url'=>array('task/calendar',
		'month' => $month->monthIndex + 1 > 12 ? 1 : $month->monthIndex + 1,
		'year' => $month->monthIndex + 1 > 12 ? $month->year + 1 : $month->year,
	),
	'linkOptions'=>array(
		'id'=>'task-next-month-menu-item',
		'class'=>'task-next-month-menu-item',
	),
);
?>

<nav class="novel-controls">
	<?php $this->widget('zii.widgets.CMenu', array(
		'items'=>$calendarMenu,
	)); ?>
</nav>
<h1><?php echo Yii::app()->format->formatMonth($month->firstDayOfMonthTimestamp) . " " . $month->year; ?></h1>


<?php 
echo PHtml::openTag('article', array('class'=>'story calendar'));
// start calendar table
echo PHtml::openTag('table');

// row of days of the week
$weekdays = array ("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
echo PHtml::openTag('thead');
echo PHtml::openTag('tr');
foreach ($weekdays as $weekdayname) {
	echo PHtml::openTag('th');
	echo PHtml::encode($weekdayname);
	echo PHtml::closeTag('th');
}
echo PHtml::closeTag('tr');
echo PHtml::closeTag('thead');

echo PHtml::openTag('tbody');

while($month->valid()) {
	if($month->currentWDay == 0) {
		echo PHtml::openTag('tr');
	}

	//add styles to day
	$htmlOptions = array(
		'class' => 'day'
	);

	$hasTasks = $calendar->hasTasksOnDate($month->currentDate);
	if($hasTasks) {
		$htmlOptions['class'] .= ' has-tasks';
	}
	else {
		$htmlOptions['class'] .= ' has-no-tasks';
	}
	
	// clarify if current month or not
	if($month->isPreviousMonth) {
		$htmlOptions['class'] .= ' previous-month';
	}
	elseif ($month->isNextMonth) {
		$htmlOptions['class'] .= ' next-month';
	}
	echo PHtml::tag('td', $htmlOptions);

	if($hasTasks) {
		echo PHtml::link(
			$month->currentMDay, '#'.PHtml::dateTimeId($month->currentTimestamp)
		);
	}
	else {
		echo PHtml::link(
			$month->currentMDay, 
			array('task/create/', 
				'day' => $month->currentMDay,
				'month' => $month->currentMon,
				'year' => $month->year,
			)
		);
	}

	// if it's the end of a week, end a the row
	if($month->currentWDay == 6) {
		echo PHtml::closeTag('tr');
	};

	// implement
	$month->next();
}

echo PHtml::closeTag('tbody');
echo PHtml::closeTag('table');
echo PHtml::closeTag('article');