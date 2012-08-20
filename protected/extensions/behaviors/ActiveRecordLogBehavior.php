<?php 

/**
 * This is the behavior class for behavior "ActiveRecordLogBehavior".
 *
 * Models wishing to use this behavior must have a public $groupId int value
 */
class ActiveRecordLogBehavior extends CActiveRecordBehavior
{
	/**
	 * List of attributes that should be ignored by the log
	 * when the ActiveRecord is updated.
	 * @var array
	 */
	public $ignoreAttributes = array();
	
	/**
	 * Private function to hold old attributes of record
	 **/	
	private $_oldAttributes = array();
	
	/**
	 * After the model saves, record the attributes
	 * @param CEvent $event
	 */
	public function afterSave($event) {
		$this->checkIsLoggable();

		// is new record?
		if ($this->Owner->isNewRecord) {
			
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

			if(!$log->save()) {
				throw new CException("Log was not saved: " . CVarDumper::dumpAsString($log->errors));
			}
		} 
		else { // updating existing record
			
			// new attributes and old attributes
			$newAttributes = $this->Owner->getAttributes();
			$oldAttributes = $this->getOldAttributes();
 
			// compare old and new
			foreach ($newAttributes as $name => $value) {
				// check that if the attribute should be ignored in the log
				if(!in_array($name, $this->ignoreAttributes)) {
					if (!empty($oldAttributes)) {
						$oldValue = $oldAttributes[$name];
					} 
					else {
						$oldValue = '';
					}
	 
					if ($value != $oldValue) {
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
							"oldAttributeValue" => $oldValue,
							"newAttributeValue" => $value,
							"userId" => Yii::app()->user->id,
						);
						if(!$log->save()) {
							throw new CException("Log was not saved: " . CVarDumper::dumpAsString($log->errors));
						}
					}
				}
			}
		}
	}
 
	/**
	 * Record the deletion
	 * @param CEvent $event
	 */
	public function afterDelete($event) {
		$this->checkIsLoggable();

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
	 * Save old values
	 * @param CEvent $event
	 */
	public function afterFind($event) {
		$this->setOldAttributes($this->Owner->getAttributes());
	}
 
	public function getOldAttributes() {
		return $this->_oldAttributes;
	}
 
	public function setOldAttributes($value) {
		$this->_oldAttributes = $value;
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
}