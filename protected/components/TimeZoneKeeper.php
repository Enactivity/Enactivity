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

	public function init(){
		// we set the default server to Cali time since that's where Ajay lives
		Yii::app()->setTimeZone("America/Los_Angeles"); 
	}

	/**
	 * Convert a server timestamp into a timestamp in user time
	 * 
	 * @param string $timestamp timestamp string
	 * @return String
	 */
	public static function serverTimeToUserTime($datetime) {
		$serverTimeZone = new DateTimeZone(Yii::app()->getTimeZone());
		$userTimeZone = new DateTimeZone(Yii::app()->user->timeZone);
		
		$dateTimeResult = new DateTime($datetime, $serverTimeZone);
		$dateTimeResult->setTimezone($userTimeZone);
		
		return $dateTimeResult->format('Y-m-d H:i:s');
	}

	/**
	 * Convert a user's timestamp into a timestamp in server time
	 * 
	 * @param string $timestamp timestamp string
	 * @return String
	 */
	public static function userTimeToServerTime($datetime) {
		$serverTimeZone = new DateTimeZone(Yii::app()->getTimeZone());
		$userTimeZone = new DateTimeZone(Yii::app()->user->timeZone);
		
		$dateTimeResult = new DateTime($datetime, $userTimeZone);
		$dateTimeResult->setTimezone($serverTimeZone);
		
		return $dateTimeResult->format('Y-m-d H:i:s');
	}
}