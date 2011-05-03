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
	 */
	public static function timeZoneArray() {
		return array( 
			'America/Puerto_Rico'=>'Atlantic Standard Time (AST)', 
			'America/New_York'=>'Eastern Standard Time (EST)', 
			'America/Chicago'=>'Central Standard Time (CST)', 
			'America/Boise'=>'Mountain Time (MDT)', 
			'America/Phoenix'=>'Mountain Standard Time (MST)', 
			'America/Los_Angeles'=>'Pacific Standard Time (PST)', 
			'America/Juneau'=>'Alaskan Standard Time (AKST)', 
			'Pacific/Honolulu'=>'Hawaii-Aleutian Standard Time (HST)', 
			'Pacific/Samoa'=>'Samoa Standard Time (UTC-11)',
			'Pacific/Guam'=>'Chamorro Standard Time (UTC+10)', 
			'Pacific/Wake'=>'Pacific/Wake Time (UTC+12)', 
		); 
	}
	
	/**
	 * Get array of time zones values
	 */
	public static function timeZoneArrayValues() {
		return array_keys(self::timeZoneArray());
	}
}