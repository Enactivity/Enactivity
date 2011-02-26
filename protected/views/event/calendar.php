<?php
$this->pageTitle = date('F', mktime(0, 0, 0, $month + 1, $day, $year));

$this->pageMenu[] = array(
	'label'=>'Previous Month', 
	'url'=>array('event/calendar',
		'month' => $month - 1 < 1 ? 12 : $month - 1,
		'year' => $month - 1 < 1 ? $year - 1 : $year,
	),
	'linkOptions'=>array('id'=>'event_next_month_menu_item'),
); 

$this->pageMenu[] = array(
	'label'=>'Next Month', 
	'url'=>array('event/calendar',
		'month' => $month + 1 > 12 ? 1 : $month + 1,
		'year' => $month + 1 > 12 ? $year + 1 : $year,
	),
	'linkOptions'=>array('id'=>'event_next_month_menu_item'),
);
?>

<?php
// start calendar table
echo PHtml::openTag('table');

// row of days of the week
$weekdays = array ("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
echo PHtml::openTag('thead');
echo PHtml::openTag('tr');
foreach ($weekdays as $weekdayname) {
	echo PHtml::openTag('th');
	echo PHtml::tag('dl');
	echo PHtml::tag('dt');
	echo $weekdayname;
	echo PHtml::closetag('dt');
	echo PHtml::closetag('dl');
	echo PHtml::closeTag('th');
}
echo PHtml::closeTag('tr');
echo PHtml::closeTag('thead');

echo PHtml::openTag('tbody');

$numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$events = $dataProvider->getData();

$firstDayofMonth = getdate(mktime(0, 0, 0, $month, 1, $year));
$dayoftheweek = $firstDayofMonth["wday"];
$i = 1 - $dayoftheweek;
$lastDayOfMonth = getdate(mktime(0, 0, 0, $month, $numDays, $year));
$lastdayoftheweekofthemonth = $lastDayOfMonth["wday"];
$bufferDays = $numDays + 6 - $lastdayoftheweekofthemonth;	

for($day = $i; $day <= $bufferDays; $day++) {
	$currentDayStart = mktime(0, 0, 0, $month, $day, $year);
	$currentDayEnd = mktime(23, 59, 59, $month, $day, $year);
	
	// if it's the start of a new week, start a new row
	$currentDayStartDate = getdate($currentDayStart);
	if($currentDayStartDate["wday"] == 0) {
		echo PHtml::openTag('tr');
	};
	
	//add styles to day based on this or last month
	$htmlOptions = array();
	$htmlOptions['class'] = 'day';
	if(($day < 1) || ($day > $numDays)) {
		$htmlOptions['class'] .= ' notThisMonth';
	}
	echo PHtml::tag('td', $htmlOptions);
	
	// create list for events of the day
	echo PHtml::tag('dl');
	
	// print the date
	echo PHtml::tag('dt');
	echo CHtml::link(date('d', $currentDayStart), array('event/create/', 'year' => $year, 'month' => $month, 'day' =>$day));
	echo PHtml::closeTag('dt');
	
	// print the events of the day
	foreach($events as $event) {
		if((Date::MySQLDateOffset($event->starts) <= $currentDayEnd)
		&& (Date::MySQLDateOffset($event->ends) >= $currentDayStart)) {
			echo PHtml::tag('dd');
			if ($currentDayStart == Date::MySQLDateOffset($event->starts)
			){
				echo PHtml::link(
					PHtml::encode(date('h:i A', strtotime($event->startTime))) . " " . PHtml::encode($event->name), 
					array('view', 'id'=>$event->id)
					); 
			}else{
				echo PHtml::link(PHtml::encode($event->name), 
					array('view', 'id'=>$event->id)
					); 
			}
			echo PHtml::closeTag('dd');
		}
	}
	
	echo PHtml::closeTag('dl');
	echo PHtml::closeTag('td');
	
	// if it's the end of a week, end a the row
	if($currentDayStartDate["wday"] == 6) {
		echo PHtml::closeTag('tr');
	};
}

echo PHtml::closeTag('tbody');
echo PHtml::closeTag('table');
?>