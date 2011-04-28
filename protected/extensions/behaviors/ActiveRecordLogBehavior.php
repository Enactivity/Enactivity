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
	 * The attribute that the feed should use to identify the model
	 * to the user
	 * @var string
	 */
	public $feedAttribute = '';
	
	private $_oldAttributes = array();
 
	/**
	 * After the model saves, record the attributes
	 * @param unknown_type $event
	 */
	public function afterSave($event) {
		// is new record?
		if ($this->Owner->isNewRecord) {
			
			$log = new ActiveRecordLog;
//			$log->description=  'User ' . Yii::app()->user->Name 
//									. ' created ' . get_class($this->Owner) 
//									. '[' . $this->Owner->getPrimaryKey() .'].';
			$log->groupId = $this->Owner->groupId;
			$log->action = ActiveRecordLog::ACTION_POSTED;
			$log->model = get_class($this->Owner);
			$log->modelId = $this->Owner->getPrimaryKey();
			$log->modelAttribute = '';
			$log->userId = Yii::app()->user->id;
			$log->save();
		} 
		else { // updating existing record
			
			// new attributes
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
						//$changes = $name . ' ('.$oldValue.') => ('.$value.'), ';
	 
						$log = new ActiveRecordLog;
	//					$log->description=  'User ' . Yii::app()->user->Name 
	//											. ' changed ' . $name . ' for ' 
	//											. get_class($this->Owner) 
	//											. '[' . $this->Owner->getPrimaryKey() .'].';
						$log->groupId = $this->Owner->groupId;
						$log->action = ActiveRecordLog::ACTION_UPDATED;
						$log->model = get_class($this->Owner);
						$log->modelId = $this->Owner->getPrimaryKey();
						$log->modelAttribute = $name;
						$log->oldAttributeValue = $oldValue;
						$log->newAttributeValue = $value;
						$log->userId = Yii::app()->user->id;
						$log->save();
					}
				}
			}
		}
	}
 
	public function afterDelete($event) {
		$log = new ActiveRecordLog;
//		$log->description =  'User ' . Yii::app()->user->Name . ' deleted ' 
//								. get_class($this->Owner) 
//								. '[' . $this->Owner->getPrimaryKey() .'].';
		$log->groupId = $this->Owner->groupId;
		$log->action = ActiveRecordLog::ACTION_DELETED;
		$log->model = get_class($this->Owner);
		$log->modelId = $this->Owner->getPrimaryKey();
		$log->modelAttribute = '';
		$log->userId = Yii::app()->user->id;
		$log->save();
	}
 
	/**
	 * Save old values
	 * @param unknown_type $event
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
}