<?php
class PHtml extends CHtml {

	/**
	 * Encodes and echos the provided text
	 * @param string
	 * @return null
	 **/
	public static function echoEncode($text) {
		echo self::encode($text);
	}

	/**
	 * Shorthand for echoEncode($text);
	 * @param string
	 * @return null
	 * @see echoEncode
	 **/
	public static function e($text) {
		self::echoEncode($text);
	}

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
	 * Generates a number field input.
	 * @param string the input name
	 * @param string the input value
	 * @param array additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	*/
	public static function numberField($name,$value='',$htmlOptions=array())
	{
		self::clientChange('change',$htmlOptions);
		return self::inputField('number',$name,$value,$htmlOptions);
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
		foreach ($data as $key => $value) {
			$value .= "ajay can hack";
		}
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
	 * Generates an number field input for a model attribute.
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
	public static function activeNumberField($model,$attribute,$htmlOptions=array())
	{
		self::resolveNameID($model,$attribute,$htmlOptions);
		self::clientChange('change',$htmlOptions);
		return self::activeInputField('number',$model,$attribute,$htmlOptions);
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
		$currentTime = date('h:i a');
		foreach ($data as $key => $value) {
			$data[$key] = $value . " (" . TimeZoneKeeper::serverTimeToTimeZone($currentTime, $key)->format('g:i a') . ")";
		}
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
	 * @param Month
	 * @param TaskCalendar
	 * @return string
	 **/
	public static function calendarDayClass($month, $calendar) {
		$class = 'day';

		if($calendar->hasTasksOnDate($month->currentDate)) {
			$class .= ' has-tasks';
		}
		else {
			$class .= ' has-no-tasks';
		}
		
		// clarify if current month or not
		if($month->isPreviousMonth) {
			$class .= ' previous-month';
		}
		elseif ($month->isNextMonth) {
			$class .= ' next-month';
		}

		return $class;
	}

	public static function calendarDayLink($month, $calendar) {

		$text = $month->currentMDay . ' ' . $month->currentWeekdayShorthand;

		if($calendar->hasTasksOnDate($month->currentDate)) {
			return PHtml::link(
				$text, '#' . PHtml::dateTimeId($month->currentTimestamp)
			);
		}
		else {
			return PHtml::link(
				$text,
				array('task/create/', 
					'day' => $month->currentMDay,
					'month' => $month->currentMon,
					'year' => $month->year,
				)
			);
		}
	}
	
	/**
	 * Generates an opening header tag for content.
	 * Note, only the open tag is generated. A close tag should be placed manually
	 * at the end of the header.
	 * @param $htmlOptions array of html options @see CHtml::openTag()
	 * @return string
	 */
	public static function beginContentHeader($htmlOptions = null) {
		if(empty($htmlOptions)) {
			$htmlOptions = array();
		}
		
		$htmlOptions['class'] = $htmlOptions['class'] . ' content-header';
		
		return self::openTag("header", $htmlOptions);
	}
	
	/**
	 * Generates a closing header for content-header tag.
	 * @return string the generated tag
	 * @see beginContentHeader
	 */
	public static function endContentHeader() {
		return self::closeTag("header");
	}

	public static function cartClass($cart) {
		$articleClass = array();
		
		$articleClass[] = "cart";
		$articleClass[] = "cart-" . PHtml::encode($cart->id);
		
		return implode(" ", $articleClass);
	}

	public static function GetGreekLetters() {
		$letters = array('' => '');
		foreach (Sweater::getGreekLetters() as $letter) {
			$letters[$letter] = ucfirst($letter);
		}
		return $letters;
	}
	
	/**
	 * Returns the classes values associated with a Comment object
	 * @param Comment $comment
	 * @return string space-separated html class string
	 */
	public static function commentClass($comment) {
		$articleClass = array();

		$articleClass[] = "comment";
		$articleClass[] = "comment-" . PHtml::encode($comment->id);

		return implode(" ", $articleClass);
	}

	/**
	 * Returns the classes values associated with a Group object
	 * @param Group $group
	 * @return string space-separated html class string
	 */
	public static function groupClass($group) {
		$articleClass = array();

		$articleClass[] = "group";
		$articleClass[] = "group-" . PHtml::encode($group->id);

		return implode(" ", $articleClass);
	}

	/**
	 * Get the url for viewing this group
	 * @param Group
	 * @return string
	*/
	public function groupUrl(Group $group)
	{
		return Yii::app()->request->hostInfo .
			Yii::app()->createUrl('group/view',
				array(
	            	'id'=>$group->id,
				)
			);
	}

	/**
	 * Get the url for viewing this task
	 * @param Task
	 * @return string containing the taskURL
	*/
	public function taskURL(Task $task)
	{
		return Yii::app()->request->hostInfo .
			Yii::app()->createUrl('task/view',
				array(
					'id'=>$task->id,
				)
			);
	}

	/**
	 * Get the url for viewing the site index
	 * @param 
	 * @return string containing the siteIndexURL
	 *
	*/

	public function siteIndexURL()
	{
		return Yii::app()->request->hostInfo .
			Yii::app()->createUrl('site/index');
	}
	
	/**
	 * Returns the classes values associated with a Task object
	 * @param Feed $feed
	 * @return string space-separated html class string
	*/
	public static function feedClass($feed) {
		$articleClass = array();
	
		$articleClass[] = "feed";
		$articleClass[] = "feed-" . PHtml::encode($feed->id);
	
		return implode(" ", $articleClass);
	}

	public static function sweaterClass($sweater) {
		$articleClass = array();
	
		$articleClass[] = "sweater";
		$articleClass[] = "sweater-" . PHtml::encode($sweater->id);
	
		return implode(" ", $articleClass);	
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
		$articleClass[] = $task->isUserParticipating ? "participating" : "not-participating";

		return implode(" ", $articleClass);
	}

	/**
	 * Returns the classes values associated with a user task object
	 * @param TaskUser $taskuser
	 * @return string space-separated html class string
	 */
	public static function taskUserClass($taskuser) {
		$articleClass = array();

		$articleClass[] = "participant";
		$articleClass[] = "participant-" . PHtml::encode($taskuser->id);
		$articleClass[] = $taskuser->isCompleted ? "completed" : "not-completed";

		return implode(" ", $articleClass);
	}
	
	/**
	* Returns the classes values associated with a user object
	* @param User $user
	* @return string space-separated html class string
	*/
	public static function userClass($user) {
		$articleClass = array();
	
		$articleClass[] = "user";
		$articleClass[] = "user-" . PHtml::encode($user->id);
	
		return implode(" ", $articleClass);
	}
}