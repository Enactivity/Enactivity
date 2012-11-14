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
		return $this->_oldAttributes;
	}
}