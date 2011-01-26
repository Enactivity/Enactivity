<?php
/**
 * CJuiDatePicker class file.
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

Yii::import('zii.widgets.jui.CJuiInputWidget');

/**
 * CJuiDatePicker displays a datepicker.
 *
 * CJuiDatePicker encapsulates the {@link http://jqueryui.com/demos/datepicker/ JUI
 * datepicker} plugin.
 *
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * $this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @version $Id: CJuiDatePicker.php 2595 2010-11-01 17:40:06Z sebathi $
 * @package zii.widgets.jui
 * @since 1.1
 */
class JuiDatePicker extends CJuiInputWidget
{
	/**
	 * @var string the locale ID (e.g. 'fr', 'de') for the language to be used by the date picker.
	 * If this property is not set, I18N will not be involved. That is, the date picker will show in English.
	 */
	public $language;

	/**
	 * @var string The i18n Jquery UI script file. It uses scriptUrl property as base url.
	 */
	public $i18nScriptFile = 'jquery-ui-i18n.min.js';

	/**
	 * @var array The default options called just one time per request. This options will alter every other CJuiDatePicker instance in the page.
	 * It has to be set at the first call of CJuiDatePicker widget in the request.
	 */
	public $defaultOptions;
	
	/**
	 * @var boolean If true, shows the widget as an inline calendar and the input as a hidden field. Use the onSelect event to update the hidden field
	 */
	public $flat = false;

	public $baseScriptUrl;
	
	public $attribute;
	public $timeAttribute;
			
	public function init()
	{
		parent::init();
		
		if($this->baseScriptUrl === null) {
			$this->baseScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathofAlias('ext.widgets') . '/jui/jquery.datepickerhider.js');
		}
	}
	
	/**
	 * Run this widget.
	 * This method registers necessary javascript and renders the needed HTML code.
	 */
	public function run()
	{
		
		list($name,$id)=$this->resolveNameID();

		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];

		if ($this->flat===false)
		{
			if($this->hasModel()){
				echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
			}	
			else{
				echo CHtml::textField($name,$this->value,$this->htmlOptions);
			}
		}
		else
		{
			if($this->hasModel())
			{
				$da = $this->attribute;
				echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
				echo CHtml::activeDropDownList($this->model, $this->timeAttribute, $this->getTimes(), $this->htmlOptions);
			}
			else
			{
				echo CHtml::textField($name,$this->value, $this->htmlOptions);
				$this->options['defaultDate'] = $this->value;
			}
			
			if (!isset($this->options['onSelect'])) {
				// add 'onSelect' event handler to datepicker
				// handler sets the value of the date to its parent & hides the picker
				$this->options['onSelect']=
					"js:function( selectedDate ) { 
						jQuery('#{$id}').val(selectedDate);
						$(this).hide('slow');
					}";
			}
			
			$this->htmlOptions['id'] = $id =  $this->htmlOptions['id'].'_container';
			$this->htmlOptions['name']= $name = $this->htmlOptions['name'].'_container';
			$this->htmlOptions['style']= $style = $this->htmlOptions['style'].'display: none;';
			echo CHtml::tag('div', $this->htmlOptions);
		}

		$options=CJavaScript::encode($this->options);
		$js = "jQuery('#{$id}').datepicker($options);";
		$cs = Yii::app()->getClientScript();
		$cs->registerScript(__CLASS__.'#'.$id, $js);
		$cs->registerScriptFile($this->baseScriptUrl, CClientScript::POS_END);

	}
	
	protected function getTimes(){
		$timeArray = array();
		$timeArray["0000"] = "12:00am";
		$timeArray["0015"] = "12:15am";
		$timeArray["0030"] = "12:30am";		
		$timeArray["0045"] = "12:45am";
		$timeArray["0100"] = "01:00am";
		$timeArray["0115"] = "01:15am";
		$timeArray["0130"] = "01:30am";
		$timeArray["0145"] = "01:45am";
		$timeArray["0200"] = "02:00am";
		$timeArray["0215"] = "02:15am";
		$timeArray["0230"] = "02:30am";
		$timeArray["0245"] = "02:45am";
		$timeArray["0300"] = "03:00am";
		$timeArray["0315"] = "03:15am";
		$timeArray["0330"] = "03:30am";
		$timeArray["0345"] = "03:45am";
		$timeArray["0400"] = "04:00am";
		$timeArray["0415"] = "04:15am";
		$timeArray["0430"] = "04:30am";
		$timeArray["0445"] = "04:45am";
		$timeArray["0500"] = "05:00am";
		$timeArray["0515"] = "05:15am";
		$timeArray["0530"] = "05:30am";
		$timeArray["0545"] = "05:45am";
		$timeArray["0600"] = "06:00am";
		$timeArray["0615"] = "06:15am";
		$timeArray["0630"] = "06:30am";
		$timeArray["0645"] = "06:45am";
		$timeArray["0700"] = "07:00am";
		$timeArray["0715"] = "07:15am";
		$timeArray["0730"] = "07:30am";
		$timeArray["0745"] = "07:45am";
		$timeArray["0800"] = "08:00am";
		$timeArray["0815"] = "08:15am";
		$timeArray["0830"] = "08:30am";
		$timeArray["0845"] = "08:45am";
		$timeArray["0900"] = "09:00am";
		$timeArray["0915"] = "09:15am";
		$timeArray["0930"] = "09:30am";
		$timeArray["0945"] = "09:45am";
		$timeArray["1000"] = "10:00am";
		$timeArray["1015"] = "10:15am";
		$timeArray["1030"] = "10:30am";
		$timeArray["1045"] = "10:45am";
		$timeArray["1100"] = "11:00am";
		$timeArray["1115"] = "11:15am";
		$timeArray["1130"] = "11:30am";
		$timeArray["1145"] = "11:45am";
		$timeArray["1200"] = "12:00pm";
		$timeArray["1215"] = "12:15pm";
		$timeArray["1230"] = "12:30pm";		
		$timeArray["1245"] = "12:45pm";
		$timeArray["1300"] = "01:00pm";
		$timeArray["1315"] = "01:15pm";
		$timeArray["1330"] = "01:30pm";
		$timeArray["1345"] = "01:45pm";
		$timeArray["1400"] = "02:00pm";
		$timeArray["1415"] = "02:15pm";
		$timeArray["1430"] = "02:30pm";
		$timeArray["1445"] = "02:45pm";
		$timeArray["1500"] = "03:00pm";
		$timeArray["1515"] = "03:15pm";
		$timeArray["1530"] = "03:30pm";
		$timeArray["1545"] = "03:45pm";
		$timeArray["1600"] = "04:00pm";
		$timeArray["1615"] = "04:15pm";
		$timeArray["1630"] = "04:30pm";
		$timeArray["1645"] = "04:45pm";
		$timeArray["1700"] = "05:00pm";
		$timeArray["1715"] = "05:15pm";
		$timeArray["1730"] = "05:30pm";
		$timeArray["1745"] = "05:45pm";
		$timeArray["1800"] = "06:00pm";
		$timeArray["1815"] = "06:15pm";
		$timeArray["1830"] = "06:30pm";
		$timeArray["1845"] = "06:45pm";
		$timeArray["1900"] = "07:00pm";
		$timeArray["1915"] = "07:15pm";
		$timeArray["1930"] = "07:30pm";
		$timeArray["1945"] = "07:45pm";
		$timeArray["2000"] = "08:00pm";
		$timeArray["2015"] = "08:15pm";
		$timeArray["2030"] = "08:30pm";
		$timeArray["2045"] = "08:45pm";
		$timeArray["2100"] = "09:00pm";
		$timeArray["2115"] = "09:15pm";
		$timeArray["2130"] = "09:30pm";
		$timeArray["2145"] = "09:45pm";
		$timeArray["2200"] = "10:00pm";
		$timeArray["2215"] = "10:15pm";
		$timeArray["2230"] = "10:30pm";
		$timeArray["2245"] = "10:45pm";
		$timeArray["2300"] = "11:00pm";
		$timeArray["2315"] = "11:15pm";
		$timeArray["2330"] = "11:30pm";
		$timeArray["2345"] = "11:45pm";
		return $timeArray;
	}
}