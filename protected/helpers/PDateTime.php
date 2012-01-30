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
			'Pacific/Samoa'=>'American Samoa',
			'Pacific/Honolulu'=>'Honolulu, Hawaii',
			'America/Juneau'=>'Juneau, Alaska',
			'America/Los_Angeles'=>'Los Angeles, California', 
			'America/Phoenix'=>'Phoenix, Arizona',
			'America/Boise'=>'Boise, Idaho', 
			'America/Chicago'=>'Chicago, Illinois', 
			'America/New_York'=>'New York, New York', 
			'America/Puerto_Rico'=>'Puerto Rico', 
			'Pacific/Guam'=>'Guam', 
			'Pacific/Wake'=>'Wake Island', 
		); 
	}
	
	/**
	 * Get array of time zones values
	 * @return array of time zone values
	 */
	public static function timeZoneArrayValues() {
		return array_keys(self::timeZoneArray());
	}
	
	/**
	 * Gets a random time zone from the list of time zones
	 * @param string $avoidZone
	 * @return string
	 */
	public static function randomButNot($avoidZone = null) {
		$zone = array_rand(self::timeZoneArray());
		if(strcmp($zone, $avoidZone) == 0) {
			return self::randomButNot($avoidZone);
		}
		return $zone;
	}
}