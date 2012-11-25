<?php 

/**
 * This is the behavior class for behavior "ActiveRecordLogBehavior".
 *
 * Models wishing to use this behavior must have a public $groupId int value
 */
class ActiveRecordLogBehavior extends CActiveRecordBehavior
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
	 **/
	public $scenarios = array();

	/** 
	 * @var boolean should a record be made when the owner is deleted?
	 **/
	public $shouldLogDeletions = false;
	
	/**
	 * After the model saves, record the attributes
	 * @param CEvent $event
	 */
	public function afterSave($event) {
		$this->checkIsLoggable();

		// is new record?
		if ($this->isIndivisibleScenario) {
			$this->recordScenario();
		} 
		elseif ($this->isDivisibleScenario) {
			$this->recordChanges();
		}
	}
 
	/**
	 * Record the deletion
	 * @param CEvent $event
	 */
	public function afterDelete($event) {
		$this->checkIsLoggable();
		if($this->shouldLogDeletions) {
			$this->recordDeletion();
		}
	}

	protected function recordScenario() {
		$log = new ActiveRecordLog();
		$log->attributes = array(
			"groupId" => $this->Owner->groupId,
			"action" => $this->Owner->scenario,
			"focalModel" => $this->Owner->focalModelClassForLog,
			"focalModelId" => $this->Owner->focalModelIdForLog,
			"focalModelName" => $this->Owner->focalModelNameForLog,
			"model" => get_class($this->Owner),
			"modelId" => $this->Owner->getPrimaryKey(),
			"modelAttribute" => null,
			"userId" => Yii::app()->user->id,
		);

		if($log->save()) {
			return true;
		}
		throw new CException("Log was not saved: " . CVarDumper::dumpAsString($log->errors));
	}

	protected function recordChanges() {
		foreach ($this->Owner->getChangedAttributes($this->scenarioAttributes) as $name => $values) {
			// check that if the attribute should be ignored in the log
			$log = new ActiveRecordLog();
			$log->attributes = array(
				"groupId" => $this->Owner->groupId,
				"action" => $this->Owner->scenario,
				"focalModel" => $this->Owner->focalModelClassForLog,
				"focalModelId" => $this->Owner->focalModelIdForLog,
				"focalModelName" => $this->Owner->focalModelNameForLog,
				"model" => get_class($this->Owner),
				"modelId" => $this->Owner->getPrimaryKey(),
				"modelAttribute" => $name,
				"oldAttributeValue" => $values['old'],
				"newAttributeValue" => $values['new'],
				"userId" => Yii::app()->user->id,
			);
			if(!$log->save()) {
				throw new CException("Log was not saved: " . CVarDumper::dumpAsString($log->errors));
			}
		}
	}

	protected function recordDeletion() {
		$log = new ActiveRecordLog();
		$log->attributes = array(
			"groupId" => $this->Owner->groupId,
			"action" => ActiveRecordLog::ACTION_DELETED,
			"focalModel" => $this->Owner->focalModelClassForLog,
			"focalModelId" => $this->Owner->focalModelIdForLog,
			"focalModelName" => $this->Owner->focalModelNameForLog,
			"model" => get_class($this->Owner),
			"modelId" => $this->Owner->getPrimaryKey(),
			"modelAttribute" => '',
			"userId" => Yii::app()->user->id,
		);
		if(!$log->save()) {
			throw new CException("Log was not saved: " . CVarDumper::dumpAsString($log->errors));
		}
	}
 
 	/**
	 * Confirm that the class is a LoggableRecord and thus compatible with this
	 * behavior
	 * @param CComponent owner class of this record
	 **/
	protected function checkIsLoggable() {
		if(!($this->Owner instanceof LoggableRecord)) {
			throw new CException("Class " . get_class($this->owner) . " does not implement LoggableRecord");
		}
	}

	/**
	 * @return boolean if the owner's save should be treated as single insert/change
	 **/
	protected function getIsIndivisibleScenario() {
		return array_key_exists($this->Owner->scenario, $this->scenarios)
			&& empty($this->scenarioAttributes);
	} 

	/**
	 * @return boolean if the owner's save should be treated as a change of multiple parts
	 **/
	protected function getIsDivisibleScenario() {
		return array_key_exists($this->Owner->scenario, $this->scenarios)
			&& !empty($this->scenarioAttributes);
	}

	/**
	 * @return array of attributes to record changes to for owner's current scenario
	**/
	protected function getScenarioAttributes() {
		return $this->scenarios[$this->Owner->scenario];
	}
}