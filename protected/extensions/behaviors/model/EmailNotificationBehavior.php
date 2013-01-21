<?php
/**
 * Class file for EmailNotificationBehavior
 */

Yii::import("application.components.ar.db.EmailableRecord");
Yii::import("application.components.notifications.NotificationBehavior");

/**
 * This is the behavior class for behavior "EmailNotificationBehavior".
 * The EmailNotificationBehavior implements EmailRecord Model
 */
class EmailNotificationBehavior extends NotificationBehavior
{	
	/**
	* After the model saves, record the attributes
	* @param CEvent $event
	*/
	public function composeSubject($model, $currentUser)
	{
		// based on the given scenario, construct the appropriate subject
		$label = $model->getScenarioLabel($model->scenario);
		$name = $model->emailName;
		$userName = $currentUser->fullName;
		return $userName . " " . $label . " " . $name;
	}

	public function afterSave($event)
	{
		if($this->enabled && $this->Owner->shouldEmail() && isset(Yii::app()->user))
		{
			// store the changes 
			$changes = array();

			// calculate changes
			if (!$this->Owner->isNewRecord) {
				$changes = $this->Owner->getChangedAttributes($this->scenarioAttributes);
			}

			$currentUser = Yii::app()->user->model;
			$message = Yii::app()->mail->constructMessage();
			$message->view = strtolower(get_class($this->Owner)). '/' . $this->Owner->scenario;
			$message->setBody(array('data'=>$this->Owner, 'changedAttributes'=>$changes ,'user'=>$currentUser), 'text/html');

			$message->setSubject(self::composeSubject($this->Owner, $currentUser));	
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

		if(!$this->enabled) {
			return;
		}

		if($this->Owner->shouldEmail() && isset(Yii::app()->user))
		{
			// store the changes 
			$currentUser = Yii::app()->user->model;
			$message = Yii::app()->mail->constructMessage();
			$message->view = strtolower(get_class($this->Owner)). '/delete';
			$message->setBody(array('data'=>$this->Owner, 'user'=>$currentUser), 'text/html');

			$message->setSubject(PHtml::encode(Yii::app()->format->formatDateTime(time())) . ' something was deleted on ' . Yii::app()->name . '!');
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
}