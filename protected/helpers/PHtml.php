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

	public static function timeDropDownList($model, $attribute, $data, $htmlOptions=array()) {
		return self::dropDownList($name, $select, $data, $htmlOptions);
	}

	public static function getTimes(){
		$timeArray = array();
		$timeArray[""] = "";
		$timeArray["00:00:00"] = "Midnight";
		$timeArray["00:15:00"] = "12:15am";
		$timeArray["00:30:00"] = "12:30am";		
		$timeArray["00:45:00"] = "12:45am";
		$timeArray["01:00:00"] = "01:00am";
		$timeArray["01:15:00"] = "01:15am";
		$timeArray["01:30:00"] = "01:30am";
		$timeArray["01:45:00"] = "01:45am";
		$timeArray["02:00:00"] = "02:00am";
		$timeArray["02:15:00"] = "02:15am";
		$timeArray["02:30:00"] = "02:30am";
		$timeArray["02:45:00"] = "02:45am";
		$timeArray["03:00:00"] = "03:00am";
		$timeArray["03:15:00"] = "03:15am";
		$timeArray["03:30:00"] = "03:30am";
		$timeArray["03:45:00"] = "03:45am";
		$timeArray["04:00:00"] = "04:00am";
		$timeArray["04:15:00"] = "04:15am";
		$timeArray["04:30:00"] = "04:30am";
		$timeArray["04:45:00"] = "04:45am";
		$timeArray["05:00:00"] = "05:00am";
		$timeArray["05:15:00"] = "05:15am";
		$timeArray["05:30:00"] = "05:30am";
		$timeArray["05:45:00"] = "05:45am";
		$timeArray["06:00:00"] = "06:00am";
		$timeArray["06:15:00"] = "06:15am";
		$timeArray["06:30:00"] = "06:30am";
		$timeArray["06:45:00"] = "06:45am";
		$timeArray["07:00:00"] = "07:00am";
		$timeArray["07:15:00"] = "07:15am";
		$timeArray["07:30:00"] = "07:30am";
		$timeArray["07:45:00"] = "07:45am";
		$timeArray["08:00:00"] = "08:00am";
		$timeArray["08:15:00"] = "08:15am";
		$timeArray["08:30:00"] = "08:30am";
		$timeArray["08:45:00"] = "08:45am";
		$timeArray["09:00:00"] = "09:00am";
		$timeArray["09:15:00"] = "09:15am";
		$timeArray["09:30:00"] = "09:30am";
		$timeArray["09:45:00"] = "09:45am";
		$timeArray["10:00:00"] = "10:00am";
		$timeArray["10:15:00"] = "10:15am";
		$timeArray["10:30:00"] = "10:30am";
		$timeArray["10:45:00"] = "10:45am";
		$timeArray["11:00:00"] = "11:00am";
		$timeArray["11:15:00"] = "11:15am";
		$timeArray["11:30:00"] = "11:30am";
		$timeArray["11:45:00"] = "11:45am";
		$timeArray["12:00:00"] = "Noon";
		$timeArray["12:15:00"] = "12:15pm";
		$timeArray["12:30:00"] = "12:30pm";		
		$timeArray["12:45:00"] = "12:45pm";
		$timeArray["13:00:00"] = "01:00pm";
		$timeArray["13:15:00"] = "01:15pm";
		$timeArray["13:30:00"] = "01:30pm";
		$timeArray["13:45:00"] = "01:45pm";
		$timeArray["14:00:00"] = "02:00pm";
		$timeArray["14:15:00"] = "02:15pm";
		$timeArray["14:30:00"] = "02:30pm";
		$timeArray["14:45:00"] = "02:45pm";
		$timeArray["15:00:00"] = "03:00pm";
		$timeArray["15:15:00"] = "03:15pm";
		$timeArray["15:30:00"] = "03:30pm";
		$timeArray["15:45:00"] = "03:45pm";
		$timeArray["16:00:00"] = "04:00pm";
		$timeArray["16:15:00"] = "04:15pm";
		$timeArray["16:30:00"] = "04:30pm";
		$timeArray["16:45:00"] = "04:45pm";
		$timeArray["17:00:00"] = "05:00pm";
		$timeArray["17:15:00"] = "05:15pm";
		$timeArray["17:30:00"] = "05:30pm";
		$timeArray["17:45:00"] = "05:45pm";
		$timeArray["18:00:00"] = "06:00pm";
		$timeArray["18:15:00"] = "06:15pm";
		$timeArray["18:30:00"] = "06:30pm";
		$timeArray["18:45:00"] = "06:45pm";
		$timeArray["19:00:00"] = "07:00pm";
		$timeArray["19:15:00"] = "07:15pm";
		$timeArray["19:30:00"] = "07:30pm";
		$timeArray["19:45:00"] = "07:45pm";
		$timeArray["20:00:00"] = "08:00pm";
		$timeArray["20:15:00"] = "08:15pm";
		$timeArray["20:30:00"] = "08:30pm";
		$timeArray["20:45:00"] = "08:45pm";
		$timeArray["21:00:00"] = "09:00pm";
		$timeArray["21:15:00"] = "09:15pm";
		$timeArray["21:30:00"] = "09:30pm";
		$timeArray["21:45:00"] = "09:45pm";
		$timeArray["22:00:00"] = "10:00pm";
		$timeArray["22:15:00"] = "10:15pm";
		$timeArray["22:30:00"] = "10:30pm";
		$timeArray["22:45:00"] = "10:45pm";
		$timeArray["23:00:00"] = "11:00pm";
		$timeArray["23:15:00"] = "11:15pm";
		$timeArray["23:30:00"] = "11:30pm";
		$timeArray["23:45:00"] = "11:45pm";
		return $timeArray;
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

	public static function activeTimeDropDownList($model, $attribute, $htmlOptions=array()) {
		$data = self::getTimes();

		self::resolveNameID($model,$attribute,$htmlOptions);
		$selection=self::resolveValue($model,$attribute);
		$options="\n".self::listOptions($selection,$data,$htmlOptions);
		self::clientChange('change',$htmlOptions);
		if($model->hasErrors($attribute))
			self::addErrorCss($htmlOptions);
		if(isset($htmlOptions['multiple']))
		{
			if(substr($htmlOptions['name'],-2)!=='[]')
				$htmlOptions['name'].='[]';
		}
		$htmlOptions['data-type'] = 'time'; // add a time type for jquery selections

		return self::tag('select',$htmlOptions,$options);
		return self::timeDropDownList($model, $attribute, $data, $htmlOptions);
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
	 * Generates html <button> tag, in addition adds a <i> and <span> tag to label
	 * @see CHtml::htmlButton
	 **/
	public static function htmlButton($label='button',$htmlOptions=array()) {
		$label = "<i></i> <span>{$label}</span>";
		return parent::htmlButton($label, $htmlOptions);
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
		if(!is_numeric($dateTime)) {
			$dateTime = strtotime($dateTime);
		}

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
	public function activityURL(Activity $activity)
	{
		return Yii::app()->request->hostInfo .
			Yii::app()->createUrl('activity/view',
				array(
					'id'=>$activity->id,
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
	 * Returns the classes values associated with an Activity object
	 * @param Activity $activity
	 * @return string space-separated html class string
	 */
	public static function activityClass($activity) {
		$articleClass = array();

		$articleClass[] = "activity";
		$articleClass[] = "activity-" . PHtml::encode($activity->id);

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
	 * @param response $response
	 * @return string space-separated html class string
	 */
	public static function responseClass($response) {
		$articleClass = array();

		$articleClass[] = "response";
		$articleClass[] = strtolower(str_replace(" ", "-", $response->status));

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