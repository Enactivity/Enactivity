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
	public function afterSave($event)
	{
		if($this->enabled && $this->owner->shouldEmail() && isset(Yii::app()->user)) {
			
			// store the changes 
			$changes = $this->owner->getChangedAttributes($this->scenarioAttributes);

			$message = Yii::app()->mail->constructMessage();

			$message->view = strtolower(get_class($this->owner)). '/' . $this->owner->scenario;
			
			$message->setBody(array(
				'data'=>$this->owner, 
				'changedAttributes'=>$changes,
				'user'=>Yii::app()->user->model
				), 'text/html');

			$message->setSubject($this->composeSubject());	
			
			$message->from = 'notifications@' . CHttpRequest::getServerName();

			$users = $this->owner->whoToNotifyByEmail();
			
			$this->sendMessage($message, $users->data);
		}
	}

	public function afterDelete($event) {

		if($this->enabled && $this->owner->shouldEmail() && isset(Yii::app()->user)) {
			
			$message = Yii::app()->mail->constructMessage();
			$message->view = strtolower(get_class($this->owner)). '/delete';
			$message->setBody(array(
				'data'=>$this->owner, 
				'user'=>Yii::app()->user->model
				), 'text/html');

			$message->setSubject(PHtml::encode(Yii::app()->format->formatDateTime(time())) . ' something was deleted on ' . Yii::app()->name . '!');
			$message->from = 'notifications@' . CHttpRequest::getServerName();

			$users = $this->owner->whoToNotifyByEmail();
			
			$this->sendMessage($message, $users->data);
		}
	}

	/**
 	 * After the model saves, record the attributes
	 * @param CEvent $event
	*/
	public function composeSubject() {
		// based on the given scenario, construct the appropriate subject
		$label = $this->owner->getScenarioLabel($this->owner->scenario);
		$name = $this->owner->emailName;
		$userName = Yii::app()->user->model->fullName;
		return $userName . " " . $label . " " . $name;
	}

	public function sendMessage($message, $users) {
		foreach($users as $user)
		{
			if(strcasecmp($user->id, Yii::app()->user->id) != 0) {
				$message->setTo($user->email);
				Yii::app()->mail->send($message); 
			}
		}
	}
}