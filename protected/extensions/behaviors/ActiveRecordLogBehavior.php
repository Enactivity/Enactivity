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
			
			$log = new ActiveRecordLog;
			$log->groupId = $this->Owner->groupId;
			$log->action = $this->Owner->scenario;
			// $log->focalModel = isset($this->focalModelClass) ? $this->focalModelClass : get_class($this->Owner); 
			// $log->focalModelId = isset($this->focalModelId) ? $this->Owner->{$this->focalModelId} : $this->Owner->getPrimaryKey();
			// $log->focalModelName = $this->feedAttribute; 
			$log->focalModel = $this->Owner->focalModelClassForLog;
			$log->focalModelId = $this->Owner->focalModelIdForLog;
			$log->focalModelName = $this->Owner->focalModelNameForLog;
			$log->model = get_class($this->Owner);
			$log->modelId = $this->Owner->getPrimaryKey();
			$log->modelAttribute = null;
			$log->userId = Yii::app()->user->id;
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
						$log = new ActiveRecordLog;
						$log->groupId = $this->Owner->groupId;
						$log->action = $this->Owner->scenario;
						$log->focalModel = $this->Owner->focalModelClassForLog;
						$log->focalModelId = $this->Owner->focalModelIdForLog;
						$log->focalModelName = $this->Owner->focalModelNameForLog;
						$log->model = get_class($this->Owner);
						$log->modelId = $this->Owner->getPrimaryKey();
						$log->modelAttribute = $name;
						$log->oldAttributeValue = $oldValue;
						$log->newAttributeValue = $value;
						$log->userId = Yii::app()->user->id;
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

		$log = new ActiveRecordLog;
		$log->groupId = $this->Owner->groupId;
		$log->action = ActiveRecordLog::ACTION_DELETED;
		$log->focalModel = $this->Owner->focalModelClassForLog;
		$log->focalModelId = $this->Owner->focalModelIdForLog;
		$log->focalModelName = $this->Owner->focalModelNameForLog;
		$log->model = get_class($this->Owner);
		$log->modelId = $this->Owner->getPrimaryKey();
		$log->modelAttribute = '';
		$log->userId = Yii::app()->user->id;
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