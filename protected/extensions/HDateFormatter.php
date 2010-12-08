<?php
/**
 * Used to format dates into human readable formats
 * @author Ajay Sharma
 *
 */
class HDateFormatter extends CComponent {

	/**
	 * 
	 */
	public function getDatesAsSentence() {
		$now = time();
        $tomorrow = strtotime("midnight +1 day", $now);
        $dayaftertomorrow = strtotime("midnight +2 day", $now);
        $dayafterweek = strtotime("midnight +7 day", $now);
        $nextyear = mktime(0, 0, 0, 0, 0, date("Y")+1);
		
		$starts = strtotime($this->starts);
		$ends = strtotime($this->ends);
		
		// Past event
		if($ends < $now) {
			$sentence .= date('l, F j, Y \a\t g:ia', $starts);
			$sentence .= ' - ';
			$sentence .= date('l, F j, Y \a\t g:ia', $ends);
		}
		// Right now
		else if($starts <= $now && $now < $ends) {
			$sentence = 'Started today at ';
			$sentence .= date('g:ia', $starts);
			$sentence .= ' - ';
			$sentence .= date('g:ia', $ends);
		}
		// Later today
		else if($now <= $starts && $starts < $tomorrow) {
			$sentence = 'Today at ';
			$sentence .= date('g:ia', $starts);
			$sentence .= ' - ';
			$sentence .= date('g:ia', $ends);
		}
		// Tomorrow
		else if($tomorrow <= $starts && $starts < $dayaftertomorrow) {
			$sentence = 'Tomorrow at ';
			$sentence .= date('g:ia', $starts);
			$sentence .= ' - ';
			$sentence .= date('g:ia', $ends);
		}
		// This week
		else if($dayaftertomorrow <= $starts && $starts < $dayafterweek) {
			// ex. Saturday, 1:00pm - 2:00pm
			$sentence .= date('l, g:ia', $starts);
			$sentence .= ' - ';
			$sentence .= date('g:ia', $ends);
		}
		// Later this year
		else if($starts < $nextyear) {
			// ex. Saturday, December 12 at 1:00pm - 2:00pm
			$sentence .= date('l, F j \a\t g:ia', $nextyear);
			$sentence .= ' - ';
			$sentence .= date('g:ia', $ends);
		}
		// Later
		else {
			// ex. Saturday, December 12 at 1:00pm - 2:00pm
			$sentence .= date('l, F j, Y \a\t g:ia', $starts);
			$sentence .= ' - ';
			$sentence .= date('g:ia', $ends);
		}
		
		return $sentence;
	}
	
	/**
	 * Returns true if the two dates are on the same day
	 * @param unknown_type $start
	 * @param unknown_type $end
	 */
	protected static function isSameDay($start, $end) {
		$startday = date('d:m:Y', $start);
		$endday = date('d:m:Y', $end);
		return $startday == $endday;
	}
}