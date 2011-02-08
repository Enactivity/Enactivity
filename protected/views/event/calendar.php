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
$daytitle = array ("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
foreach ($daytitle as $title) {
		echo PHtml::tag('dl', array('class' => 'daytitle'));
		echo PHtml::tag('dt');
		echo $title;
		echo PHtml::closetag('dt');
		echo PHtml::closetag('dl');
}
?>

<?php
$numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$firstDayofMonth = getdate(mktime(0, 0, 0, $month, 1, $year));
$dayoftheweek = $firstDayofMonth["wday"];
$i = 1 - $dayoftheweek;
$lastDayOfMonth = getdate(mktime(0, 0, 0, $month, $numDays, $year));
$lastdayoftheweekofthemonth = $lastDayOfMonth["wday"];
$bufferDays = $numDays + 6 - $lastdayoftheweekofthemonth;	

for($day = $i; $day <= $bufferDays; $day++) {
	$currentDayStart = mktime(0, 0, 0, $month, $day, $year);
	$currentDayEnd = mktime(23, 59, 59, $month, $day, $year);
	//add styles to day based on this or last month
	$htmlOptions = array();
	$htmlOptions['class'] = 'day';
	if(($day < 1) || ($day > $numDays)) {
		$htmlOptions['class'] .= ' notThisMonth';
	}
	
	echo PHtml::tag('dl', $htmlOptions);
	echo PHtml::tag('dt');
	echo date('d', mktime(0, 0, 0, $month, $day, $year));
	echo PHtml::closeTag('dt');
	
	foreach($dataProvider->getData() as $event) {
		if((Date::MySQLDateOffset($event->starts) <= $currentDayEnd)
		&& (Date::MySQLDateOffset($event->ends) >= $currentDayStart)) {
			echo PHtml::tag('dd');
			echo PHtml::link(PHtml::encode($event->startTime) . " " . PHtml::encode($event->name), 
				array('view', 'id'=>$event->id)
				); 
			echo PHtml::closeTag('dd');
		}
	}
	echo PHtml::closeTag('dl');
}
?>