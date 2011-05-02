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
	 * @param CEvent $event
	 */
	public function afterSave($event) {
		// is new record?
		if ($this->Owner->isNewRecord) {
			
			$log = new ActiveRecordLog;
			$log->groupId = $this->Owner->groupId;
			$log->action = $this->Owner->scenario;
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
						$log = new ActiveRecordLog;
						$log->groupId = $this->Owner->groupId;
						$log->action = $this->Owner->scenario;
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
 
	/**
	 * Record the deletion
	 * @param CEvent $event
	 */
	public function afterDelete($event) {
		$log = new ActiveRecordLog;
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
	 * @param CEvent $event
	 */
	public function afterFind($event) {
		$this->setOldAttributes($this->Owner->getAttributes());
	}
	
	/**
	 * Returns the text label for the specified scenario.
	 * In particular, if the attribute name is in the form of "post.author.name",
	 * then this method will derive the label from the "author" relation's "name" attribute.
	 * @param string $attribute the attribute name
	 * @return string the attribute label
	 */
	public function getScenarioLabel($scenario)
	{
		$labels = $this->Owner->scenarioLabels();
		if(isset($labels[$scenario])) {
			return $labels[$scenario];
		}
		else if(strpos($scenario, '.') !== false)
		{
			$segs=explode('.',$scenario);
			$name=array_pop($segs);
			$model=$this;
			foreach($segs as $seg)
			{
				$relations=$model->getMetaData()->relations;
				if(isset($relations[$seg]))
					$model=CActiveRecord::model($relations[$seg]->className);
				else
					break;
			}
			return $model->getScenarioLabel($name);
		}
		else
			return $this->Owner->generateAttributeLabel($scenario);
	}
 
	public function getOldAttributes() {
		return $this->_oldAttributes;
	}
 
	public function setOldAttributes($value) {
		$this->_oldAttributes = $value;
	}
}