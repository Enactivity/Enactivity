<?php
class PDateTime {
	
	public static function MySQLDateOffset($dateTimeString, $year_offset='', $month_offset='', $day_offset='') { 
		return mktime(0,
				0,
				0, 
				substr($dateTimeString, 5, 2) + $month_offset,
				substr($dateTimeString, 8, 2) + $day_offset,
				substr($dateTimeString, 0, 4) + $year_offset); 
	}
	
	/**
	 * Get array of time zones
	 * @return array of String keys => String values
	 */
	public static function timeZoneArray() {
		return array( 
			'Pacific/Samoa'=>'Pacific/Samoa',
			'Pacific/Honolulu'=>'Pacific/Honolulu',
			'America/Juneau'=>'America/Juneau',
			'America/Los_Angeles'=>'America/Los Angeles', 
			'America/Phoenix'=>'America/Phoenix',   
			'America/Boise'=>'America/Boise', 
			'America/Chicago'=>'America/Chicago', 
			'America/New_York'=>'America/New York', 
			'America/Puerto_Rico'=>'America/Puerto Rico', 
			'Pacific/Guam'=>'Pacific/Guam', 
			'Pacific/Wake'=>'Pacific/Wake', 
		); 
	}
	
	/**
	 * Get array of time zones values
	 * @return array of time zone values
	 */
	public static function timeZoneArrayValues() {
		return array_keys(self::timeZoneArray());
	}
}