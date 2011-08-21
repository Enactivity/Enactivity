<?php
/**
 * Class file for TaskEmailNotificationBehavior
 */

/**
 * This is the behavior class for behavior "SendEmailNotificationBehavior".
 *
 * Models wishing to use this behavior must have a public $groupId int value
 */
class TaskEmailNotificationBehavior extends CActiveRecordBehavior
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
						$log = new ActiveRecordLog;
						$log->groupId = $this->Owner->groupId;
						$log->action = 'updated';
						$log->model = get_class($this->Owner);
						$log->modelId = $this->Owner->getPrimaryKey();
						$log->modelAttribute = $name;
						$log->userId = Yii::app()->user->id;
						$log->save();
						
						// foreach notifyee
						foreach($this->Owner->descendantParticipants as $user) {
// 							$mail = new ActionNotificationEmail;
// 							$mail->to = $user->email;
// 							$mail->shouldEmail = true;
// 							Yii::app()->mailer->send($mail);
							$message = new YiiMailMessage;
							$message->view = 'notification';
							
							//userModel is passed to the view
							$message->setBody(array('user'=>$user), 'text/html');
							
							$message->setSubject('Something wonderful has happened on Poncla!');
							$message->addTo($user->email);
							$message->from = Yii::app()->params['adminEmail'];
							Yii::app()->mail->send($message);
						}
					}
				}
			}
		} 
		else {
			$log = new ActiveRecordLog;
			$log->groupId = $this->Owner->groupId;
			$log->action = 'posted';
			$log->model = get_class($this->Owner);
			$log->modelId = $this->Owner->getPrimaryKey();
			$log->modelAttribute = '';
			$log->userId = Yii::app()->user->id;
			$log->save();
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