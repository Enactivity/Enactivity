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

	const SCENARIO_DELETE = 'delete';
	const SCENARIO_INSERT = 'insert'; 
	const SCENARIO_TRASH = 'trash';
	const SCENARIO_UNTRASH = 'untrash';
	const SCENARIO_UPDATE = 'update'; 
	const SCENARIO_INVITE = 'invite';
	const SCENARIO_JOIN = 'join'; 
	const SCENARIO_COMPLETE = 'complete';
	const SCENARIO_UNCOMPLETE = 'uncomplete';

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

	public function createSubject($owner)
	{
		// based on the given scenario, construct the appropriate subject

		$class = get_class($owner);
		var_dump($class);
		switch($class)
		{
			case group:

				if(strcasecmp($owner->scenario, self::SCENARIO_UPDATE) == 0)
				{
					return 'Your group\'s name was updated to ' . $owner->name . ' on Poncla.';
				}

			case groupuser:

				if(strcasecmp($owner->scenario, self::SCENARIO_INVITE) == 0)
				{
					return 'More people were invited to ' . $owner->group->name . ' on Poncla.';
				}
				elseif(strcasecmp($owner->scenario, self::SCENARIO_JOIN) == 0)
				{
					return 'Someone just joined ' . $owner->name . ' on Poncla.';		
				}

			case task:

				if(strcasecmp($owner->scenario, self::SCENARIO_DELETE) == 0)
				{
					return $owner->name . ' was deleted from ' . $owner->group->name . ' on Poncla.';
				}
				elseif(strcasecmp($owner->scenario, self::SCENARIO_INSERT) == 0)
				{
					return $owner->name . ' was created on ' . $owner->group->name . ' on Poncla.';	
				}
				elseif(strcasecmp($owner->scenario, self::SCENARIO_UPDATE) == 0)
				{
					return $owner->name . ' updated ' . $owner->group->name . ' on Poncla.';
				}
					
			case taskcomment:

				if(strcasecmp($owner->scenario, self::SCENARIO_INSERT) == 0)
				{
					return 'Someone left a comment for ' . $owner->group->name . ' on Poncla.';
				}
				elseif(strcasecmp($owner->scenario, self::SCENARIO_REPLY) == 0)
				{
					return 'Someone replied to a comment in ' . $owner->group->name . ' on Poncla.';
				}

			case taskuser:

				if(strcasecmp($owner->scenario, self::SCENARIO_COMPLETE) == 0)
				{
					return 'Someone completed ' . $owner->task->name . ' from ' . $owner->group->name . ' on Poncla.com';
				}
				elseif(strcasecmp($owner->scenario, self::SCENARIO_DELETE) == 0)
				{
					return 'Someone was deleted from ' . $owner->group->name . ' on Poncla.';	
				}
				elseif(strcasecmp($owner->scenario, self::SCENARIO_INSERT) == 0)
				{
					return 'Someone signed up for ' . $owner->task->name . ' in ' . $owner->group->name . ' on Poncla.com.';
				}
				elseif(strcasecmp($owner->scenario, self::SCENARIO_TRASH) == 0)
				{
					return 'Someone from ' . $owner->group->name . ' quit ' . $owner->group->name . ' on Poncla.com.';
				}
				elseif(strcasecmp($owner->scenario, self::SCENARIO_UNCOMPLETE) == 0)
				{
					return 'Someone from ' . $owner->group->name . ' resumed ' . $owner->task->name . ' on Poncla.com.';
				}
				elseif(strcasecmp($owner->scenario, self::SCENARIO_UNTRASH) == 0)
				{
					return 'Someone from ' . $owner->group->name . ' is now participating continuing ' . $owner->task->name . ' on Poncla.com';
				}

			default:

				return "Psst! Something exciting just happened on Poncla!";

		}

	}

	public function afterSave($event)
	{
		if($this->Owner->shouldEmail() && isset(Yii::app()->user))
		{
			// store the changes 
			$changes = array();
			
			// new attributes and old attributes
			$newAttributes = $this->Owner->getAttributes();
			$oldAttributes = $this->Owner->getOldAttributes();
 
			// compare old and new
			foreach ($newAttributes as $name => $value) {
				// check that if the attribute should be ignored in the log
				$oldValue = empty($oldAttributes) ? '' : $oldAttributes[$name];

	 			if ($value != $oldValue) {
	 				if(!in_array($name, $this->ignoreAttributes) 
	 					&& array_key_exists($name, $oldAttributes)
	 					&& array_key_exists($name, $newAttributes)
	 				)
	 				{
	 					// Hack: Format the datetimes into readable strings
	 					if ($this->Owner->metadata->columns[$name]->dbType == 'datetime') {
							$oldAttributes[$name] = isset($oldAttributes[$name]) ? Yii::app()->format->formatDateTime(strtotime($oldAttributes[$name])) : '';
							$newAttributes[$name] = isset($newAttributes[$name]) ? Yii::app()->format->formatDateTime(strtotime($newAttributes[$name])) : '';
						}

	 					$changes[$name] = array('old'=>$oldAttributes[$name], 'new'=>$newAttributes[$name]);
	 				}
				}
			}
			
			$currentUser = Yii::app()->user->model;
			$message = Yii::app()->mail->constructMessage();
			$message->view = strtolower(get_class($this->Owner)). '/' . $this->Owner->scenario;
			$message->setBody(array('data'=>$this->Owner, 'changedAttributes'=>$changes ,'user'=>$currentUser), 'text/html');
			
			$message->setSubject(self::createSubject($this->Owner));	

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
	
	public function afterDelete($event) {
		if($this->Owner->shouldEmail() && isset(Yii::app()->user))
		{
			// store the changes 
			$currentUser = Yii::app()->user->model;
			$message = Yii::app()->mail->constructMessage();
			$message->view = strtolower(get_class($this->Owner)). '/delete';
			$message->setBody(array('data'=>$this->Owner, 'user'=>$currentUser), 'text/html');
				
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
 
 	/**
 	 * Get the old attribute for the current owner
 	**/
	public function getOldAttributes() {
		return $this->_oldAttributes;
	}
 
	public function setOldAttributes($value) {
		$this->_oldAttributes = $value;
	}

}