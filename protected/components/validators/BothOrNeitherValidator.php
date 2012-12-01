<?php

/**
 * Validator class ensures that both the attribute and other attribute
 * are set or unset.
 *
 */
class BothOrNeitherValidator extends CValidator {
	
	/**
	 * @var string the name of the other attribute to check
	 */
	public $otherAttribute;

	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 */
	protected function validateAttribute($object, $attribute)
	{
		$value = $object->$attribute;
		$otherValue = $object->{$this->otherAttribute};

		if(StringUtils::isNotBlank($value) && StringUtils::isBlank($otherValue)) {
			$message = $this->message !==null ? $this->message : Yii::t('yii','If {attribute} is provided, then {otherAttribute} is also needed.');
			$this->addError($object, $attribute, $message, array(
				'{otherAttribute}' => $object->getAttributeLabel($this->otherAttribute),
			));
		}
	}
}

?>