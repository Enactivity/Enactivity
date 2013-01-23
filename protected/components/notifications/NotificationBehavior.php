<?php
/**
 * Class file for NotificationBehavior
 */

/**
 * This is the behavior class for behavior "NotificationBehavior".
 */
abstract class NotificationBehavior extends CActiveRecordBehavior
{	
	/**
	 * List of scenarios that should be treated as a record change
	 * format: 
	 * array(
	 *    'scenario1' => array()
	 *    'scenario2' => array('attribute1', 'attribute2', ...)
	 *    'scenario3' => array('attribute3', 'attribute4', ...)
	 *    ...
	 * )
	 * @var array
	 **/
	public $scenarios = array();

	/** 
	 * @var boolean should a record be made when the owner is deleted?
	 **/
	public $shouldLogDeletions = false;


	/**
	 * @return boolean if the owner's save should be treated as notification event
	 **/
	protected function getIsNotifiableScenario() {
		return array_key_exists($this->owner->scenario, $this->scenarios);
	} 

    /**
	 * @return boolean if the owner's save should be treated as single insert/change
	 **/
	protected function getIsIndivisibleScenario() {
		return array_key_exists($this->owner->scenario, $this->scenarios)
			&& empty($this->scenarioAttributes);
	} 

	/**
	 * @return boolean if the owner's save should be treated as a change of multiple parts
	 **/
	protected function getIsDivisibleScenario() {
		return array_key_exists($this->owner->scenario, $this->scenarios)
			&& !empty($this->scenarioAttributes);
	}

	/**
	 * @return array of attributes to record changes to for owner's current scenario
	**/
	protected function getScenarioAttributes() {
		return $this->scenarios[$this->owner->scenario];
	}
}