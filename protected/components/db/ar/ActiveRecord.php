<?php
/**
 * ActiveRecord is the customized base active record class.
 * All model classes for this application should extend from this base class.
 **/
abstract class ActiveRecord extends CActiveRecord {

	/**
	 * @var array that contains attributes of the record at the time it was found
	 **/
	private $_oldAttributes = array();

	/**
	 * @return array scenario string => label string
	 **/
	public function scenarioLabels() {
		throw new Exception("scenarioLabels() has not been implemented for this class");
	}

	/**
	 * Returns the text label for the specified scenario.
	 * @param string $scenario the scenario name
	 * @return string the scenario label
	 */
	public function getScenarioLabel($scenario)
	{
		$labels = $this->scenarioLabels();
		if(array_key_exists($scenario, $labels)) {
			return $labels[$scenario];
		}
		return $this->generateAttributeLabel($scenario);
	}


	/**
	 * Saves the initial attributes into oldAttributes
	 * @see CActiveRecord::afterFind
	 */ 
	public function afterFind() {
		parent::afterFind();

		// Save initial attributes for later review
		$this->_oldAttributes = $this->attributes;
	}
 
 	/**
 	 * Get the old attribute for the current owner
 	**/
	public function getOldAttributes() {
		if($this->isNewRecord) {
			throw new CException("Record is new and has no old values.");
		}

		return $this->_oldAttributes;
	}

	/** 
	 * @return array in form of:
	 *	'attributeName' => 'old' => old value
	 *	                   'new' => new value
	 **/
	public function getChangedAttributesExcept($ignoreAttributes = array()) {
		// new attributes and old attributes
		$currentAttributes = $this->attributes;
		$oldAttributes = $this->oldAttributes;

		$changes = array();

		// compare old and new
		foreach ($currentAttributes as $name => $currentValue) {
			// check that if the attribute should be ignored
			$oldValue = empty($oldAttributes) ? '' : $oldAttributes[$name];

 			if ($currentValue != $oldValue) {
 				if(!in_array($name, $ignoreAttributes) 
 					&& array_key_exists($name, $oldAttributes)
 					&& array_key_exists($name, $currentAttributes)
 				)
 				{
 					// Hack: Format the datetimes into readable strings
 					if ($this->metadata->columns[$name]->dbType == 'datetime') {
						$oldAttributes[$name] = isset($oldAttributes[$name]) ? Yii::app()->format->formatDateTime(strtotime($oldAttributes[$name])) : '';
						$currentAttributes[$name] = isset($currentAttributes[$name]) ? Yii::app()->format->formatDateTime(strtotime($currentAttributes[$name])) : '';
					}
 					$changes[$name] = array('old'=>$oldAttributes[$name], 'new'=>$currentAttributes[$name]);
 				}
			}
		}

		return $changes;
	}
}