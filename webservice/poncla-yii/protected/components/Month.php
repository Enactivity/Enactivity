<?php
/**
 * 
 * @author ajsharma
 */
class Month extends CComponent {
	
	/**
	 * The integer value of the month
	 * @var int
	 */
	public $intValue;
	
	/**
	 * The integer value of the year
	 * @var int
	 */
	public $year;
	
	/**
	 * Construct a new month, intValue value equals the current month and year
	 * @param intValue int
	 * @param year int
	 */
	public function Month($intValue = null, $year = null) {
		
		if(is_null($intValue)) {
			$this->intValue = date('m');
		}
		else {
			$this->intValue = $intValue;
		}
		
		if(is_null($year)) {
			$this->year = date('Y');
		}
		else {
			$this->year = $year;		
		}
	}
	
	/**
	 * Returns the number of days in the month
	 */
	public function getCalendarDays() {
		return cal_days_in_month(CAL_GREGORIAN, $this->intValue, $this->year);
	}
	
	/**
	 * Returns the timestamp of the first moment of the month;
	 * Enter description here ...
	 */
	public function getTimestamp() {
		return mktime(0, 0, 0, $this->intValue, 1, $this->year);
	}
	
	/**
	 * Returns the timestamp for midnight of the first day of the month
	 * @see getdate()
	 * @return array an associative array of information related to the timestamp.
	 */
	public function getFirstDayOfMonth() {
		return getdate($this->timestamp);
	}
	
	/**
	 * Returns the timestamp for midnight of the last day of the month
	 * @see getdate()
	 * @return array an associative array of information related to the timestamp.
	 */
	public function getLastDayOfMonth() {
		return getdate(mktime(0, 0, 0, $this->intValue, $this->calendarDays, $this->year));
	}
	
	/**
	 * Get the number of days preceeding in the week before the first
	 * day of the month.  For instance, if it's Monday, then there is
	 * 1 day before in the week (Sunday).
	 * @return int number of days before in the week.
	 */
	public function getPreBufferDays() {
		$firstDay = $this->firstDayOfMonth;
		$dayoftheweek = $firstDay["wday"];
		return 1 - $dayoftheweek;
	}
	
	/**
	 * Get the number of days remaining in the week after the last
	 * day of the month.  For instance, if it's Friday, then there is
	 * 1 day left in the week (Saturday).
	 * @return int number of days left in the week.
	 */
	public function getPostBufferDays() {
		$lastDay = $this->lastDayOfMonth;
		$dayoftheweek = $lastDay["wday"];
		return $this->calendarDays + 6 - $dayoftheweek;
	}
}