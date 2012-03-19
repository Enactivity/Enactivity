<?php
/**
 * Class file for EmailNotificationBehavior
 */

/**
 * This is the behavior class for behavior "EmailNotificationBehavior".
 * The EmailNotificationBehavior implements EmailRecord Model
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

	public function afterSave($event)
	{
		if($this->Owner->shouldEmail())
		{
			$currentUser = Yii::app()->user->model;
			$message = Yii::app()->mail->constructMessage();
			$message->view = strtolower(get_class($this->Owner)). '/' . $this->Owner->scenario;
			$message->setBody(array('data'=>$this->Owner, 'newAttributes'=>$this->Owner->getAttributes(), 'oldAttributes'=>$this->getOldAttributes(), 'user'=>$currentUser), 'text/html');
				
			$message->setSubject('Psst. Something just happened on Poncla!');
			$message->from = 'notifications@' . CHttpRequest::getServerName();
			
			$users = $this->Owner->whoToNotifyByEmail();
			foreach($users->data as $user)
			{
				if(strcasecmp($user->id, $currentUser->id) != 0) {
					$message->setTo($user->email);
					Yii::app()->mail->send($message); 
				}
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