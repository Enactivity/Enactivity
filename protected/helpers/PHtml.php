<?php
class PHtml extends CHtml {
	
	/**
	 * Generates an date field input.
	 * @param string the input name
	 * @param string the input value
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 */
	public static function dateField($name,$value='',$htmlOptions=array())
	{
		self::clientChange('change',$htmlOptions);
		return self::inputField('date',$name,$value,$htmlOptions);
	}
	
	/**
	 * Generates an datetime field input.
	 * @param string the input name
	 * @param string the input value
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 */
	public static function dateTimeField($name,$value='',$htmlOptions=array())
	{
		self::clientChange('change',$htmlOptions);
		return self::inputField('datetime',$name,$value,$htmlOptions);
	}
	
	/**
	 * Generates an datetime-local field input.
	 * @param string the input name
	 * @param string the input value
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 */
	public static function dateTimeLocalField($name,$value='',$htmlOptions=array())
	{
		self::clientChange('change',$htmlOptions);
		return self::inputField('datetime-local',$name,$value,$htmlOptions);
	}
	
	/**
	 * Generates an email field input.
	 * @param string the input name
	 * @param string the input value
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 */
	public static function emailField($name,$value='',$htmlOptions=array())
	{
		self::clientChange('change',$htmlOptions);
		return self::inputField('email',$name,$value,$htmlOptions);
	}
	
	/**
	 * Generates a time field input.
	 * @param string the input name
	 * @param string the input value
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 */
	public static function timeField($name,$value='',$htmlOptions=array())
	{
		self::clientChange('change',$htmlOptions);
		return self::inputField('time',$name,$value,$htmlOptions);
	}
	
	
	/**
	 * Generates a drop down list with the list of acceptable timezones
	 * @param string $name the input name
	 * @param string $select the selected value
	 * @param array $htmlOptions
	 */
	public static function timeZoneDropDownList(string $name, string $select, array $htmlOptions=array()) {
		$data = PDateTime::timeZoneArray();
		return self::dropDownList($name, $select, $data, $htmlOptions);
	}
	
	/**
	 * Generates an date field input for a model attribute.
	 * If the attribute has input error, the input field's CSS class will
	 * be appended with {@link errorCss}.
	 * @param CModel the data model
	 * @param string the attribute
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see activeInputField
	 */
	public static function activeDateField($model,$attribute,$htmlOptions=array())
	{
		self::resolveNameID($model,$attribute,$htmlOptions);
		self::clientChange('change',$htmlOptions);
		return self::activeInputField('date',$model,$attribute,$htmlOptions);
	}
	
	/**
	 * Generates an datetime field input for a model attribute.
	 * If the attribute has input error, the input field's CSS class will
	 * be appended with {@link errorCss}.
	 * @param CModel the data model
	 * @param string the attribute
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see activeInputField
	 */
	public static function activeDateTimeField($model,$attribute,$htmlOptions=array())
	{
		self::resolveNameID($model,$attribute,$htmlOptions);
		self::clientChange('change',$htmlOptions);
		return self::activeInputField('datetime',$model,$attribute,$htmlOptions);
	}
	
	/**
	 * Generates an datetime-local field input for a model attribute.
	 * If the attribute has input error, the input field's CSS class will
	 * be appended with {@link errorCss}.
	 * @param CModel the data model
	 * @param string the attribute
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see activeInputField
	 */
	public static function activeDateTimeLocalField($model,$attribute,$htmlOptions=array())
	{
		self::resolveNameID($model,$attribute,$htmlOptions);
		self::clientChange('change',$htmlOptions);
		return self::activeInputField('datetime-local',$model,$attribute,$htmlOptions);
	}
	
	/**
	 * Generates an email field input for a model attribute.
	 * If the attribute has input error, the input field's CSS class will
	 * be appended with {@link errorCss}.
	 * @param CModel the data model
	 * @param string the attribute
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see activeInputField
	 */
	public static function activeEmailField($model,$attribute,$htmlOptions=array())
	{
		self::resolveNameID($model,$attribute,$htmlOptions);
		self::clientChange('change',$htmlOptions);
		return self::activeInputField('email',$model,$attribute,$htmlOptions);
	}
	
	/**
	 * Generates an time field input for a model attribute.
	 * If the attribute has input error, the input field's CSS class will
	 * be appended with {@link errorCss}.
	 * @param CModel the data model
	 * @param string the attribute
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see activeInputField
	 */
	public static function activeTimeField($model,$attribute,$htmlOptions=array())
	{
		self::resolveNameID($model, $attribute, $htmlOptions);
		self::clientChange('change', $htmlOptions);
		return self::activeInputField('time', $model, $attribute, $htmlOptions);
	}
	
	/**
	 * Generates a drop down list with the list of acceptable timezones
	 * @param string $name the input name
	 * @param string $select the selected value
	 * @param array $htmlOptions
	 */
	public static function activeTimeZoneDropDownList($model, $attribute, $htmlOptions=array()) {
		$data = PDateTime::timeZoneArray();
		return self::activeDropDownList($model, $attribute, $data, $htmlOptions);
	}
	
	/**
	 * Provides an alternative to nl2br, and returns a string with
	 * newlines replaced with <p> tags
	 * @param mixed $value
	 * @return string $string
	 */
	public static function nl2p($value) {
		// Remove existing HTML formatting to avoid double-wrapping things
		$value = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $value);
		
        return '<p>'.preg_replace("/([\n]{1,})/i", "</p>\n<p>", trim($value)).'</p>';
	}
	
	/**
	 * Replaces plain text links with formatted that contains 
	 * <a hrefs>.
	 * @param string $string
	 * @return string 
	 */
	public static function makeClickable($string) {
		$urlHtml = preg_replace(
			'/(?<!S)((http(s?):\/\/)|(www.))+([\w.1-9\&=#?\-~%;\/]+)/',
			'<a href="http$3://$4$5">http$3://$4$5</a>', $string);
		return ($urlHtml);
	}
	
	/**
	 * Returns the id attribute value for a tag based 
	 * @param int $dateTime
	 * @return string id value
	 */
	public static function dateTimeId($dateTime) {
		$id = "day-";
		$id .= date('Y', $dateTime);
		$id .= '-' . date('m', $dateTime);
		$id .= '-' . date('d', $dateTime);
		
		return $id;
	}
	
	/**
	 * Returns the classes values associated with a Task object 
	 * @param Task $task
	 * @return string space-separated html class string
	 */
	public static function taskClass($task) {
		$articleClass = array();
		
		$articleClass[] = "task";
		$articleClass[] = "task-" . PHtml::encode($task->id);
		$articleClass[] = $task->hasStarts ? "starts" : "";
		$articleClass[] = $task->isCompleted ? "completed" : "not-completed";
		$articleClass[] = $task->isInheritedTrash ? "trash" : "not-trash";
		$articleClass[] = $task->isUserParticipating ? "participating" : "not-participating";
		
		return implode(" ", $articleClass);
	}
}