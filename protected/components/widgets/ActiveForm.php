<?php
/**
 * Override of Yii's {@link CActiveForm} class, with
 * redirects to {@link PHtml} instead of {@link CHtml} 
 * @author Ajay Sharma
 */
class ActiveForm extends CActiveForm {

	public function init()
	{
		parent::init();
		CHtml::$afterRequiredLabel = '';
	}
	
	/**
	 * Renders a date field for a model attribute.
	 * This method is a wrapper of {@link PHtml::activeDateField}.
	 * Please check {@link PHtml::activeDateField} for detailed information
	 * about the parameters for this method.
	 */
	public function dateField($model,$attribute,$htmlOptions=array())
	{
		return PHtml::activeDateField($model,$attribute,$htmlOptions);
	}
	
	/**
	 * Renders a datetime field for a model attribute.
	 * This method is a wrapper of {@link PHtml::activeDateTimeField}.
	 * Please check {@link PHtml::activeDateTimeField} for detailed information
	 * about the parameters for this method.
	 */
	public function dateTimeField($model,$attribute,$htmlOptions=array())
	{
		return PHtml::activeDateTimeField($model,$attribute,$htmlOptions);
	}
	
/**
	 * Renders a datetime-local field for a model attribute.
	 * This method is a wrapper of {@link PHtml::activeDateTimeLocalField}.
	 * Please check {@link PHtml::activeDateTimeLocalField} for detailed information
	 * about the parameters for this method.
	 */
	public function dateTimeLocalField($model,$attribute,$htmlOptions=array())
	{
		return PHtml::activeDateTimeLocalField($model,$attribute,$htmlOptions);
	}
	
	/**
	 * Renders an email field for a model attribute.
	 * This method is a wrapper of {@link PHtml::activeEmailField}.
	 * Please check {@link PHtml::activeEmailField} for detailed information
	 * about the parameters for this method.
	 */
	public function emailField($model,$attribute,$htmlOptions=array())
	{
		return PHtml::activeEmailField($model,$attribute,$htmlOptions);
	}
	
	/**
	 * Renders a time field for a model attribute.
	 * This method is a wrapper of {@link PHtml::activeTimeField}.
	 * Please check {@link PHtml::activeTimeField} for detailed information
	 * about the parameters for this method.
	 */
	public function timeField($model,$attribute,$htmlOptions=array())
	{
		return PHtml::activeTimeField($model,$attribute,$htmlOptions);
	}
	
	/**
	 * Renderrs a drop down list with the list of acceptable timezones
	 * This method is a wrapper of {@link PHtml::activeTimeZoneDropDownList}.
	 * Please check {@link PHtml::activeTimeZoneDropDownList} for detailed information
	 * about the parameters for this method.
	 */
	public function timeZoneDropDownList($model, $attribute, $htmlOptions=array()) {
		return PHtml::activeTimeZoneDropDownList($model, $attribute, $htmlOptions);
	}
}