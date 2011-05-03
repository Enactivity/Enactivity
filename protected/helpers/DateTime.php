<?php
class DateTime {
	
	public static function MySQLDateOffset($dateTimeString, $year_offset='', $month_offset='', $day_offset='') { 
		return mktime(0,
				0,
				0, 
				substr($dateTimeString, 5, 2) + $month_offset,
				substr($dateTimeString, 8, 2) + $day_offset,
				substr($dateTimeString, 0, 4) + $year_offset); 
	}
}