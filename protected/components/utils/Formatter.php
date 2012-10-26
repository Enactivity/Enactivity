<?php
/**
 * Formatter class file.
 *
 * @author Ajay Sharma
 */

Yii::import("application.components.utils.TimeZoneKeeper");

/**
 * Formatter extends CFormatter to provides a set of commonly used 
 * data formatting methods.
 *
 * @author Ajay Sharma
 */
class Formatter extends CFormatter {
	
	/**
	 * Formats the value as a HTML-encoded plain text and converts newlines with HTML p tags.
	 * @param mixed $value the value to be formatted
	 * @return string the formatted result
	 */
	public function formatPText($value)
	{
		return PHtml::nl2p(PHtml::encode($value));
	}
	
	/**
	 * Formats the value into a semi-rich text format where newlines are 
	 * translates into paragraphs, and links are made clickable.
	 * @param mixed $value the string to be formatted
	 * @return string the formatted result 
	 */
	public function formatStyledText($value) {
		$enrichedText = self::formatPText($value);
		$enrichedText = PHtml::makeClickable($enrichedText);
		return $enrichedText;
	}
	
	/**
	 * Format a datetime timestamp as a time
	 * @param mixed $value time or timestamp
	 * @return String
	 */
	public function formatTime($value) {
		if(empty($value)) {
			return null;
		}

		if(is_string($value)) {
			$value = strtotime($value);
		}

		return parent::formatTime($value);
	}

	/**
	 * Format a datetime timestamp as a day
	 * @param mixed $value time or timestamp
	 * @return String
	 */
	public function formatDate($value)
	{
		if(empty($value)) {
			return null;
		}

		if(is_string($value)) {
			$value = strtotime($value);
		}

		$date = date('d/m/Y', $value);
		$prefix = '';
		if($date == date('d/m/Y')) {
			$prefix = 'Today, ';
		}
		else if($date == date('d/m/Y', time() - (24 * 60 * 60))) {
			$prefix = 'Yesterday, ';
		}
		else if($date == date('d/m/Y', time() + (24 * 60 * 60))) {
			$prefix = 'Tomorrow, ';
		}
		else {
			$prefix = date('l, ', $value);
		}
		
		return $prefix . parent::formatDate($value);
	}
	
	/**
	 * Format a datetime timestamp
	 * @param mixed $value time or timestamp
	 * @return String
	 */
	public function formatDateTime($value)
	{
		if(empty($value)) {
			return null;
		}

		if(is_string($value)) {
			$value = strtotime($value);
		}

		$date = date('d/m/Y', $value);
		if($date == date('d/m/Y')) {
			return 'Today at ' . parent::formatTime($value);
		}
		else if($date == date('d/m/Y', time() - (24 * 60 * 60))) {
			return 'Yesterday at ' . parent::formatTime($value);
		}
		else if($date == date('d/m/Y', time() + (24 * 60 * 60))) {
			return 'Tomorrow at ' . parent::formatTime($value);
		}
		
		return date('F d, Y \a\\t h:i a', $value);
	}
	
	/**
	 * @param mixed $value time or timestamp
	 * @return String
	 */
	public function formatMonth($value)
	{
		if(empty($value)) {
			return null;
		}

		if(is_string($value)) {
			$value = strtotime($value);
		}

		return date('F', $value);
	}
	
	/**
	 * Format the datetime as a string such as "5 minutes ago" or 
	 * "2 days from now".
	 * @param mixed $value time or timestamp
	 * @return string
	 */
	function formatDateTimeAsAgo($value) {
		if(empty($value)) {
			return null;
		}

		if(is_string($value)) {
			$value = strtotime($value);
		}

		$periods = array("second", "minute", "hour");
		$lengths = array("60","60","24");
		$now = strtotime(TimeZoneKeeper::serverTimeToUserTime(null));

		// is it future date or past date
		if($now >= $value) {
			$difference = $now - $value;
			$tense = "ago";
		}
		else {
			$difference = $value - $now;
			$tense = "from now";
		}
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		$difference = round($difference);
		if($difference != 1) {
			//      $periods[$j] .= "s"; // plural for English language
			$periods = array("seconds", "minutes", "hours");
		}
		
		if($difference > 12 && $j == 2) {
			return $this->formatDateTime($value);
		}
		
		return "$difference $periods[$j] {$tense}";
	}
}