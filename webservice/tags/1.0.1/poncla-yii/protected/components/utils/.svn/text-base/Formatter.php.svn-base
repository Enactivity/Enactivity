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
}