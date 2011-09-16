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
	 * 
	 * @param string $timestamp timestamp string
	 * @return String
	 */
	public static function serverTimeToUserTime($datetime) {
		$serverTimeZone = new DateTimeZone(Yii::app()->getTimeZone());
		$dateTime = new DateTime($datetime);
		
		if(isset(Yii::app()->user) && isset(Yii::app()->user->timeZone)) {
			$userTimeZone = new DateTimeZone(Yii::app()->user->timeZone);
			$dateTime = new DateTime($datetime, $serverTimeZone);
			$dateTime->setTimezone($userTimeZone);
		}
		
		return $dateTime->format('Y-m-d H:i:s');
	}

	/**
	 * Convert a user's timestamp into a timestamp in server time
	 * 
	 * @param string $timestamp timestamp string
	 * @return String
	 */
	public static function userTimeToServerTime($datetime) {
		$serverTimeZone = new DateTimeZone(Yii::app()->getTimeZone());
		$dateTime = new DateTime($datetime);
		
		if(isset(Yii::app()->user) && isset(Yii::app()->user->timeZone)) {
			$userTimeZone = new DateTimeZone(Yii::app()->user->timeZone);
			$dateTime = new DateTime($datetime, $userTimeZone);
		}
		
		$dateTime->setTimezone($serverTimeZone);
		
		return $dateTime->format('Y-m-d H:i:s');
	}
}