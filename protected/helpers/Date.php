<?php
class Date {
	
	public static function MySQLDateOffset($dt, $year_offset='', $month_offset='', $day_offset='') { 
		return mktime(0,
				0,
				0, 
				substr($dt,5,2) + $month_offset,
				substr($dt,8,2) + $day_offset,
				substr($dt,0,4) + $year_offset); 
	}
}