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
 
	public function afterSave($event) {
		if (!$this->Owner->isNewRecord) {
 
			// new attributes
			$newAttributes = $this->Owner->getAttributes();
			$oldAttributes = $this->getOldAttributes();
 
			// compare old and new
			foreach ($newAttributes as $name => $value) {
				if(!in_array($name, $this->ignoreAttributes)) {
					if (!empty($oldAttributes)) {
						$old = $oldAttributes[$name];
					} else {
						$old = '';
					}
	 
					if ($value != $old) {
						//$changes = $name . ' ('.$old.') => ('.$value.'), ';
	 
						$log = new ActiveRecordLog;
	//					$log->description=  'User ' . Yii::app()->user->Name 
	//											. ' changed ' . $name . ' for ' 
	//											. get_class($this->Owner) 
	//											. '[' . $this->Owner->getPrimaryKey() .'].';
						$log->groupId = $this->Owner->groupId;
						$log->action = 'updated';
						$log->model = get_class($this->Owner);
						$log->modelId = $this->Owner->getPrimaryKey();
						$log->modelAttribute = $name;
						$log->userId = Yii::app()->user->id;
						$log->save();
					}
				}
			}
		} 
		else {
			$log = new ActiveRecordLog;
//			$log->description=  'User ' . Yii::app()->user->Name 
//									. ' created ' . get_class($this->Owner) 
//									. '[' . $this->Owner->getPrimaryKey() .'].';
			$log->groupId = $this->Owner->groupId;
			$log->action = 'posted';
			$log->model = get_class($this->Owner);
			$log->modelId = $this->Owner->getPrimaryKey();
			$log->modelAttribute = '';
			$log->userId = Yii::app()->user->id;
			$log->save();
		}
	}
 
	public function afterDelete($event) {
		$log = new ActiveRecordLog;
//		$log->description =  'User ' . Yii::app()->user->Name . ' deleted ' 
//								. get_class($this->Owner) 
//								. '[' . $this->Owner->getPrimaryKey() .'].';
		$log->groupId = $this->Owner->groupId;
		$log->action = 'deleted';
		$log->model = get_class($this->Owner);
		$log->modelId = $this->Owner->getPrimaryKey();
		$log->modelAttribute = '';
		$log->userId = Yii::app()->user->id;
		$log->save();
	}
 
	public function afterFind($event) {
		// Save old values
		$this->setOldAttributes($this->Owner->getAttributes());
	}
 
	public function getOldAttributes() {
		return $this->_oldAttributes;
	}
 
	public function setOldAttributes($value) {
		$this->_oldAttributes = $value;
	}
}