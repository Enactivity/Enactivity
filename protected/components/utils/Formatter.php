<?php
/**
 * Formatter class file.
 *
 * @author Ajay Sharma
 */

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
	
	public function formatDate($value)
	{
		$date = date('d/m/Y', $value);
		if($date == date('d/m/Y')) {
			return 'Today';
		}
		else if($date == date('d/m/Y', time() - (24 * 60 * 60))) {
			return 'Yesterday';
		}
		else if($date == date('d/m/Y', time() + (24 * 60 * 60))) {
			return 'Tomorrow';
		}
		
		return parent::formatDate($value);
	}
	
	public function formatDateTime($value)
	{
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
		
		return parent::formatDateTime($value);
	}
}