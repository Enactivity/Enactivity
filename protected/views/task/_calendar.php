<?php 
// start calendar table
echo PHtml::openTag('table', array('class'=>'calendar'));

// row of days of the week
$weekdays = array ("Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat");
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
		if((PDateTime::MySQLDateOffset($task->starts) <= $currentDayEnd)
		&& (PDateTime::MySQLDateOffset($task->starts) >= $currentDayStart)) {
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
		echo PHtml::link(
			date('d', $currentDayStart), 
			array('task/calendar/', 
				'year' => $month->year, 
				'month' => $month->intValue, 
				'#' => 'day-' . $month->year . '-' . date('m', $currentDayStart) . '-' . date('d', $currentDayStart) //day-YYYY-mm-dd
			)
		);
	}

	// if it's the end of a week, end a the row
	if($currentDayStartDate["wday"] == 6) {
		echo PHtml::closeTag('tr');
	};
}

echo PHtml::closeTag('tbody');
echo PHtml::closeTag('table');