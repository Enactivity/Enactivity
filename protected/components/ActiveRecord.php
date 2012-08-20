<?php
/**
 * ActiveRecord is the customized base active record class.
 * All model classes for this application should extend from this base class.
 **/
abstract class ActiveRecord extends CActiveRecord {

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
		if(isset($labels[$scenario])) {
			return $labels[$scenario];
		}
		return $this->generateAttributeLabel($scenario);
	}
}