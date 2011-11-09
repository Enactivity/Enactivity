<?php
/**
 * CJuiDateTimePicker class file.
 */

Yii::import('zii.widgets.jui.CJuiWidget');

/**
 * CJuiDateTimePicker displays a datepicker and a time combobox
 *
 * CJuiDateTimePicker encapsulates the {@link http://jqueryui.com/demos/datepicker/ JUI
 * datepicker} plugin.
 *
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * $this->widget('zii.widgets.jui.CJuiDateTimePicker', array(
 *     'name'=>'publishDate',
 *     // additional javascript options for the date picker plugin
 *     'options'=>array(
 *         'showAnim'=>'fold',
 *     ),
 *     'htmlOptions'=>array(
 *         'style'=>'height:20px;'
 *     ),
 * ));
 * </pre>
 *
 * By configuring the {@link options} property, you may specify the options
 * that need to be passed to the JUI datepicker plugin. Please refer to
 * the {@link http://jqueryui.com/demos/datepicker/ JUI datepicker} documentation
 * for possible options (name-value pairs).
 */
class JuiDateTimePicker extends CJuiWidget
{
	/**
	 * @var CModel the data model associated with this widget.
	 */
	public $model;
	
	/**
	* @var string the datetime attribute associated with this widget.
	* The name can contain square brackets (e.g. 'name[1]') which is used to collect tabular data input.
	*/
	public $dateTimeAttribute;
	
	/**
	 * @var string the date attribute associated with this widget.
	 * The name can contain square brackets (e.g. 'name[1]') which is used to collect tabular data input.
	 */
	public $dateAttribute;
	
	/**
	 * @var string the time attribute associated with this widget.
	 * The name can contain square brackets (e.g. 'name[1]') which is used to collect tabular data input.
	 */
	public $timeAttribute;
	
	/**
	 * @var string the input name. This must be set if {@link model} is not set.
	 */
	public $dateInputName;
	
	/**
	 * @var string the input name. This must be set if {@link model} is not set.
	 */
	public $timeName;
	
	/**
	 * @var string the input value
	 */
	public $dateValue;
	
	/**
	 * @var string the input value
	 */
	public $timeValue;
	
	/**
	 * @var array The default options called just one time per request. This options will alter every other JuiDateTimePicker instance in the page.
	 * It has to be set at the first call of JuiDateTimePicker widget in the request.
	 */
	public $defaultOptions;
	
	/**
	 * Run this widget.
	 * This method registers necessary javascript and renders the needed HTML code.
	 */
	public function run()
	{  
		// construct text field
		list($dateInputName, $dateInputId) = $this->resolveNameID($this->dateInputName, $this->dateAttribute);
		list($timeInputName, $timeInputId) = $this->resolveNameID($this->timeName, $this->timeAttribute);

		if(isset($this->htmlOptions['id'])) {
			$dateInputId = $this->htmlOptions['id'];
		}
		else {
			$this->htmlOptions['id'] = $dateInputId;
		}
		if(isset($this->htmlOptions['name'])) {
			$dateInputName = $this->htmlOptions['name'];
		}
		
		// label
		echo CHTML::activelabelEx($this->model, $this->dateTimeAttribute);
		
		// clear link
		echo ' ';
		echo CHtml::link("Clear",'#',
			array(
				'class' => 'clear-field clear-date-time'	
			)
		);
		echo CHtml::tag('br');
		
		// set html options for time drop down
		$timeHtmlOptions = $this->htmlOptions;
		$timeHtmlOptions['id'] = $timeInputId;
		
		if($this->hasModel()) {
			echo CHtml::activeTextField($this->model, $this->dateAttribute, $this->htmlOptions);
			echo CHtml::activeDropDownList($this->model, $this->timeAttribute, $this->getTimes(), $timeHtmlOptions);
		}
		else {
			echo CHtml::textField($dateInputName, $this->dateValue, $this->htmlOptions);
			$this->options['defaultDate'] = $this->dateValue;
			echo CHtml::dropDownList($timeInputName, $this->timeValue, $this->getTimes(), $timeHtmlOptions);
		}
		
		if (!isset($this->options['onSelect'])) {
			// add 'onSelect' event handler to datepicker
			// handler sets the value of the date to its parent & hides the picker
			$this->options['onSelect'] =
				"js:function( selectedDate ) { 
					jQuery('#{$dateInputId}').val(selectedDate);
					$(this).hide('slow');
				}";
		}
		$this->htmlOptions['id'] = $this->htmlOptions['id'].'_container';
		
		if(empty($this->htmlOptions['class'])) {
			$this->htmlOptions['class'] = '';
		} 
		$this->htmlOptions['class'] = $this->htmlOptions['class'] . '_container';
		
		if(empty($this->htmlOptions['style'])) {
			$this->htmlOptions['style'] = '';
		}
		$this->htmlOptions['style']= $this->htmlOptions['style'].'display: none;';
		
		echo CHtml::tag('div', $this->htmlOptions);
		echo CHtml::closeTag('div');

		$this->registerCalendarScripts($dateInputId);
	}
	
	protected function getTimes(){
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
	 * @return array the name and the ID of the input.
	 */
	protected function resolveNameID($name, $attribute)
	{
		if($name !== null)
			$name = $name;
		else if(isset($this->htmlOptions['name']))
			$name = $this->htmlOptions['name'];
		else if($this->hasModel())
			$name = CHtml::activeName($this->model, $attribute);
		else
			throw new CException(Yii::t('zii','{class} must specify "model" and "date/timeAttribute" or "date/timeName" property values.', array('{class}'=>get_class($this))));

		if(($id = $this->getId(false)) === null)
		{
			if(isset($this->htmlOptions['id']))
				$id = $this->htmlOptions['id'];
			else
				$id = CHtml::getIdByName($name);
		}

		return array($name, $id);
	}

	/**
	 * @return boolean whether this widget is associated with a data model.
	 */
	protected function hasModel()
	{
		return $this->model instanceof CModel 
			&& $this->dateAttribute!==null
			&& $this->timeAttribute!==null
			;
	}
	
	/**
	 * Register a script to show and hide the calendar script
	 * @param String $dateInputId
	 * @return null
	 */
	protected function registerShowHideCalendarScript($dateInputId) {
		$cs = Yii::app()->getClientScript();
		
		// attach script to input to prevent keyboard pop-ups on focus
		$focusScript =
					"$('#{$dateInputId}').live(\"focus\",
						function() {
							$('#{$dateInputId}').blur();
							$('#{$dateInputId}_container').show('slow');
						}
					);";
		$cs->registerScript(__CLASS__.'#'.$dateInputId, $focusScript, CClientScript::POS_BEGIN);
		
		// encode $this->options[] and pass to jquery datepicker
		$options = CJavaScript::encode($this->options);
		$addDatepickerScript = "$('#{$dateInputId}_container').datepicker($options);";
		$cs->registerScript(__CLASS__.'#'.$dateInputId.'_container', $addDatepickerScript, CClientScript::POS_END);
	}
	
	/**
	 * add a script to clear the date and time when the "clear" link is pressed
	 * @return null
	 */
	protected function registerClearScript() {
		$cs = Yii::app()->getClientScript();
		
		$script = Yii::getPathOfAlias('application.components.widgets.jui.assets') .'/clearDateTime.js';
		$clearDateTimeScript = Yii::app()->getAssetManager()->publish($script);
		$cs->registerScriptFile($clearDateTimeScript, CClientScript::POS_BEGIN);
	}
	
	/**
	 * Regsiter the javascripts needed for the date picker
	 * @param String $dateInputId id attribute for datepicker's date input
	 * @return null
	 */
	protected function registerCalendarScripts($dateInputId) {
		$this->registerShowHideCalendarScript($dateInputId);
		$this->registerClearScript();
	}
}