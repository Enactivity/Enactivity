<?php
/**
 * Component for translating timezones between database and server.
 * TimeZone keeper is designed to be preloaded by the application and
 * convert times from database time to user time.
 * 
 * @author ajsharma
 * @version 1.0
 * @package application.components
 */
class TimeZoneKeeper extends CComponent{

	public $userTimeZone;
	public $serverTimeZone;

	// we set the default server to Cali time since that's where Ajay lives
	const DEFAULTTIMEZONE = "America/Los_Angeles"; 
	
	public function init(){
		Yii::app()->setTimeZone(self::DEFAULTTIMEZONE); 
	}

	/**
	 * Convert a server timestamp into a timestamp in user time
	 * If user time is not set, 
	 *
	 * @param string $timestamp timestamp string
	 * @param string timezone
	 * @return String
	*/
	public static function serverTimeToTimeZone($datetime, $timeZone) {
		$serverTimeZone = new DateTimeZone(Yii::app()->getTimeZone());
		$convertedDateTime = new DateTime($datetime, $serverTimeZone);
		
		$userTimeZone = new DateTimeZone($timeZone);
		$convertedDateTime->setTimezone($userTimeZone);
		
		return $convertedDateTime;
	}
	
	/**
	 * Convert a server timestamp into a timestamp in user time
	 * 
	 * @param string $timestamp timestamp string
	 * @return String
	 */
	public static function serverTimeToUserTime($datetime) {
		//FIXME: add tests & user serverTimeToTime
		$serverTimeZone = new DateTimeZone(Yii::app()->getTimeZone());
		$convertedDateTime = new DateTime($datetime);
		
		if(isset(Yii::app()->user) && isset(Yii::app()->user->timeZone)) {
			$userTimeZone = new DateTimeZone(Yii::app()->user->timeZone);
			$convertedDateTime = new DateTime($datetime, $serverTimeZone);
			$convertedDateTime->setTimezone($userTimeZone);
		}
		
		return $convertedDateTime->format('Y-m-d H:i:s');
	}

	/**
	 * Convert a user's timestamp into a timestamp in server time
	 * 
	 * @param string $timestamp timestamp string
	 * @return String
	 */
	public static function userTimeToServerTime($datetime) {
		$serverTimeZone = new DateTimeZone(Yii::app()->getTimeZone());
		$convertedDateTime = new DateTime($datetime);
		
		if(isset(Yii::app()->user) && isset(Yii::app()->user->timeZone)) {
			$userTimeZone = new DateTimeZone(Yii::app()->user->timeZone);
			$convertedDateTime = new DateTime($datetime, $userTimeZone);
		}
		
		$convertedDateTime->setTimezone($serverTimeZone);
		
		return $convertedDateTime->format('Y-m-d H:i:s');
	}
}