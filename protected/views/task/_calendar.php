<?php 
/**
 * @uses $datedTasksProvider
 * @uses $datelessTasksProvider
 * @uses $newTask
 * @uses $month
 */
?>

<?php 
// nav
$calendarMenu = array();
$calendarMenu[] = array(
	'label'=>'Previous', 
	'url'=>array('task/calendar',
		'month' => $month->intValue - 1 < 1 ? 12 : $month->intValue - 1,
		'year' => $month->intValue - 1 < 1 ? $month->year - 1 : $month->year,
	),
	'linkOptions'=>array(
		'id'=>'task-previous-month-menu-item',
		'class'=>'task-previous-month-menu-item',
	),
);

$calendarMenu[] = array(
	'label'=>'Next', 
	'url'=>array('task/calendar',
		'month' => $month->intValue + 1 > 12 ? 1 : $month->intValue + 1,
		'year' => $month->intValue + 1 > 12 ? $month->year + 1 : $month->year,
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
<h1><?php echo Yii::app()->format->formatMonth($month->timestamp) . " " . $month->year; ?></h1>


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

for($day = $month->preBufferDays; $day <= $month->postBufferDays; $day++) {
	$currentDayStart = mktime(0, 0, 0, $month->intValue, $day, $month->year);
	$currentDayEnd = mktime(23, 59, 59, $month->intValue, $day, $month->year);

	// if it's the start of a new week, start a new row
	$currentDayStartDate = getdate($currentDayStart);
	if($currentDayStartDate["wday"] == 0) {
		echo PHtml::openTag('tr');
	};

	//add styles to day
	$htmlOptions = array();
	$htmlOptions['class'] = 'day';
	
	$hasTasks = false;
	foreach($dataProvider->getData() as $task) {
		if(($task->startTimestamp <= $currentDayEnd)
		&& ($task->startTimestamp >= $currentDayStart)) {
			$hasTasks = true;
		}
	}
	if($hasTasks) {
		$htmlOptions['class'] .= ' has-tasks';
	}
	else {
		$htmlOptions['class'] .= ' has-no-tasks';
	}
	
	// clarify if current month or not
	if($day < 1) {
		$htmlOptions['class'] .= ' previous-month';
	}
	elseif ($day > $month->calendarDays) {
		$htmlOptions['class'] .= ' next-month';
	}
	echo PHtml::tag('td', $htmlOptions);

	// print the date
	if($day > 0 && $day <= $month->calendarDays) {
		$day = date('d', $currentDayStart);
		
		if($hasTasks) {
			echo PHtml::link(
				$day, 
				array(Yii::app()->request->pathInfo, 
					'#' => PHtml::dateTimeId($currentDayStart),
				)
			);
		}
		else {
			echo PHtml::link(
				$day, 
				array('task/create/', 
					'day' => $day,
					'month' => $month->intValue,
					'year' => $month->year,
				)
			);
		}
	}

	// if it's the end of a week, end a the row
	if($currentDayStartDate["wday"] == 6) {
		echo PHtml::closeTag('tr');
	};
}

echo PHtml::closeTag('tbody');
echo PHtml::closeTag('table');
echo PHtml::closeTag('article');