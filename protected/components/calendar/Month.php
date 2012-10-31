<?php
/**
 * Class representing a month of dates.  Should be iterable where
 * key = index of dates, and value = date
 * @author ajsharma
 */
class Month extends CComponent implements Iterator {
	
	/**
	 * The integer value of the month
	 * @var int
	 */
	public $monthIndex;
	
	/**
	 * The integer value of the year
	 * @var int
	 */
	public $year;

	/**
	 * Array of dates in month, each in the form of an associative array
	 * @see http://php.net/manual/en/function.getdate.php
	 **/
	private $dates = array();

	/**
	 * Current index of the iterator
	 **/
	private $iteratorPosition = 0;
	
	/**
	 * Construct a new month
	 * @param monthIndex int current month index (i.e. 1 - 12)
	 * @param year int (e.g. 2012)
	 * @return Month
	 */
	public function __construct($monthIndex = null, $year = null) {
		
		if(is_null($monthIndex)) {
			$this->monthIndex = date('m');
		}
		else {
			$this->monthIndex = $monthIndex;
		}
		
		if(is_null($year)) {
			$this->year = date('Y');
		}
		else {
			$this->year = $year;		
		}

		$this->fillDates();
	}

	/**
	 * Load dates array using current month and year along with pre and post 
	 * buffered days.
	 * @return null
	 */
	protected function fillDates() {
		for($dateIndex = $this->preBufferDays; $dateIndex <= $this->postBufferDays; $dateIndex++) {
			$dayStartTimestamp = mktime(0, 0, 0, $this->monthIndex, $dateIndex, $this->year);
			$this->dates[] = getdate($dayStartTimestamp);
		}
	}
	
	/** 
	 * Get the name of the current month
	 * @return string
	 */
	public function getName() {
		return Yii::app()->format->formatMonth($this->firstDayOfMonthTimestamp);
	}

	/** 
	 * Get the name of the previous month
	 * @return string
	 */
	public function getNameOfPreviousMonth() {
		return Yii::app()->format->formatMonth($this->firstDayOfMonthTimestamp - 1);
	}

	/** 
	 * Get the name of the next month
	 * @return string
	 */
	public function getNameOfNextMonth() {
		return Yii::app()->format->formatMonth($this->lastDayOfMonthTimestamp + 1);
	}


	/**
	 * Returns the number of days in the month
	 */
	public function getCalendarDaysCount() {
		return cal_days_in_month(CAL_GREGORIAN, $this->monthIndex, $this->year);
	}
	
	/**
	 * Returns the timestamp of the first moment of the month;
	 * @return int
	 */
	public function getFirstDayOfMonthTimestamp() {
		return mktime(0, 0, 0, $this->monthIndex, 1, $this->year);
	}
	
	/**
	 * Returns the timestamp for midnight of the first day of the month
	 * @see getdate()
	 * @return array an associative array of information related to the timestamp.
	 */
	public function getFirstDayOfMonth() {
		return getdate($this->firstDayOfMonthTimestamp);
	}

	/**
	 * Returns the timestamp of the last moment of the month;
	 * @return int
	 */
	public function getLastDayOfMonthTimestamp() {
		return mktime(23, 59, 59, $this->monthIndex, $this->calendarDaysCount, $this->year);
	}
	
	/**
	 * Returns the timestamp for midnight of the last day of the month
	 * @see getdate()
	 * @return array an associative array of information related to the timestamp.
	 */
	public function getLastDayOfMonth() {
		return getdate($this->lastDayOfMonthTimestamp);
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
		return $this->calendarDaysCount + 6 - $dayoftheweek;
	}

	/****************************
	 * Iterator interface functions
	 * @see http://php.net/manual/en/class.iterator.php
	 ****************************/

	public function rewind() {
        $this->iteratorPosition = 0;
    }

    public function current() {
        return $this->dates[$this->iteratorPosition];
    }

    public function key() {
        return $this->iteratorPosition;
    }

    public function next() {
        ++$this->iteratorPosition;
    }

    public function valid() {
        return isset($this->dates[$this->iteratorPosition]);
    }

    public function getCurrentSeconds() {
    	$current = $this->current();
    	return $current['seconds'];
    }

    public function getCurrentMinutes() {
    	$current = $this->current();
    	return $current['minutes'];
    }

    public function getCurrentHours() {
    	$current = $this->current();
    	return $current['hours'];
    }

    public function getCurrentMDay() {
    	$current = $this->current();
    	$number = $current['mday'];
    	if(strlen($number) <= 1) {
    		$number = '0' . $number;
    	}
    	return $number;
    }

    public function getCurrentWDay() {
    	$current = $this->current();
    	return $current['wday'];
    }

    public function getCurrentMon() {
    	$current = $this->current();
    	$number = $current['mon'];
    	if(strlen($number) <= 1) {
    		$number = '0' . $number;
    	}
    	return $number;
    }

    public function getCurrentYear() {
    	$current = $this->current();
    	return $current['year'];
    }

    public function getCurrentYDay() {
    	$current = $this->current();
    	return $current['yday'];
    }

    public function getCurrentWeekday() {
    	$current = $this->current();
    	return $current['weekday'];
    }

    /** 
     * Get the shorthand (three letter) version of the current weekday
     * (e.g. 'Sun', 'Mon')
     * @return string
     **/
    public function getCurrentWeekdayShorthand() {
    	return substr($this->currentWeekday, 0, 3);
    }

    public function getCurrentMonth() {
    	$current = $this->current();
    	return $current['month'];
    }

	/** 
     * Get the shorthand (three or four letter) version of the current month
     * (e.g. 'Jan', 'June')
     * @return string
     **/
    public function getCurrentMonthShorthand() {
    	$currentMonth = $this->currentMonth;
    	
    	// Handle four letter months (June, July)
    	if(strlen($currentMonth) <= 4) {
    		return $currentMonth;
    	}

    	return substr($this->currentMonth, 0, 3);
    }

    public function getCurrentTimestamp() {
    	$current = $this->current();
    	return $current['0'];
    }

    public function getCurrentDate() {
    	return $this->currentYear . '-' . $this->currentMon . '-' . $this->currentMDay;
    }

    public function getIsCurrentlyFirstOfTheMonth() {
    	$current = $this->current();
    	$number = $current['mday'];
    	if(intval($number) == 1) {
    		return true;
    	}
    	return false;
    }

    /**
     * Is the current date part of the previous month?
     * @return boolean
     **/
    public function getIsPreviousMonth() {
    	$dateArray = $this->current();
    	return $dateArray['0'] < $this->firstDayOfMonthTimestamp;
    }

	/**
     * Is the current date part of the next month?
     * @return boolean
     **/
    public function getIsNextMonth() {
    	$dateArray = $this->current();
    	return $dateArray['0'] > $this->lastDayOfMonthTimestamp;
    }
}