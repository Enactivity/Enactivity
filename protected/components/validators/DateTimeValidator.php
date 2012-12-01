<?php

/**
 * Validator class ensures the provided attribute 
 * is an understandable datetime
 *
 */
class DateTimeValidator extends CValidator {
	
	/**
	 * @var boolean whether the attribute value can be null or empty. Defaults to true,
	 * meaning that if the attribute is empty, it is considered valid.
	 */
	public $allowEmpty=true;

	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 */
	protected function validateAttribute($object, $attribute)
	{
		$value = $object->$attribute;
		if($this->allowEmpty && StringUtils::isBlank($value)) {
			return;
		}

		if(!strtotime($value)) {
			$message = $this->message !==null ? $this->message : Yii::t('yii','The date & time format of {attribute} is unrecognized.');
			$this->addError($object, $attribute, $message);
		}
	}
}

?>