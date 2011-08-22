<?php
/**
 * Class file for EmailNotificationBehavior
 */

/**
 * This is the behavior class for behavior "EmailNotificationBehavior".
 *
 * Models wishing to use this behavior must have a public $groupId int value
 */
class EmailNotificationBehavior extends CActiveRecordBehavior
{
	/**
	 * List of attributes that should be ignored by the log
	 * when the ActiveRecord is updated.
	 * @var array
	 */
	public $ignoreAttributes = array();
	
	/**
	 * The attribute that the email should use to identify the model
	 * to the user
	 * @var string
	 */
	public $emailAttribute = '';
	
	/**
	 * The attribute that the behavior should use to get the list of 
	 * users who should be emailed.  Should return User[].
	 * @var string
	 */
	public $notifyAttribute = '';
	
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
			$log->focalModel = isset($this->focalModelClass) ? $this->focalModelClass : get_class($this->Owner);
			$log->focalModelId = isset($this->focalModelId) ? $this->Owner->{$this->focalModelId} : $this->Owner->getPrimaryKey();
			$log->model = get_class($this->Owner);
			$log->modelId = $this->Owner->getPrimaryKey();
			$log->modelAttribute = null;
			$log->userId = Yii::app()->user->id;
			$this->notify($log);
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
						$log->focalModel = isset($this->focalModelClass) ? $this->focalModelClass : get_class($this->Owner);
						$log->focalModelId = isset($this->focalModelId) ? $this->Owner->{$this->focalModelId} : $this->Owner->getPrimaryKey();
						$log->model = get_class($this->Owner);
						$log->modelId = $this->Owner->getPrimaryKey();
						$log->modelAttribute = $name;
						$log->oldAttributeValue = $oldValue;
						$log->newAttributeValue = $value;
						$log->userId = Yii::app()->user->id;
						$this->notify($log);
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
		$log->focalModel = isset($this->focalModelClass) ? $this->focalModelClass : get_class($this->Owner);
		$log->focalModelId = isset($this->focalModelId) ? $this->Owner->{$this->focalModelId} : $this->Owner->getPrimaryKey();
		$log->model = get_class($this->Owner);
		$log->modelId = $this->Owner->getPrimaryKey();
		$log->modelAttribute = '';
		$log->userId = Yii::app()->user->id;
		$this->notify($log);
	}
	 
	protected function notify($log) {
		foreach($this->Owner->{$this->notifyAttribute} as $user) {
			// don't want to email person who did the action
			if($user->id != $log->userId) {
				$message = new YiiMailMessage;
				$message->view = 'notification';
					
				$message->setBody(array('data'=>$log), 'text/html');
					
				$message->setSubject('Poncla activity!');
				$message->addTo($user->email);
				$message->from = 'notifications@' . $_SERVER['SERVER_NAME'];
				Yii::app()->mail->send($message); 
			}
		}
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