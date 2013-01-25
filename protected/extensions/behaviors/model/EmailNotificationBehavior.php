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
	public function getEnabled() {
		return Yii::app()->params['ext.behaviors.model.EmailNotificationBehavior.enabled'];
	}


	public function afterSave($event)
	{
		if($this->enabled && $this->isNotifiableScenario && isset(Yii::app()->user)) {

			$users = $this->owner->whoToNotifyByEmail();

			$subject = $this->composeSubject();	

			$viewPath = strtolower(get_class($this->owner)). '/' . $this->owner->scenario;
			
			$viewData = array(
				'data'=>$this->owner, 
				'changedAttributes'=>$this->owner->getChangedAttributes($this->scenarioAttributes),
				'user'=>Yii::app()->user->model
			);

			$from = 'notifications@' . CHttpRequest::getServerName();
			
			$this->sendMessage($users, $subject, $viewPath, $viewData, $from);
		}
	}

	/**
 	 * After the model saves, record the attributes
	 * @param CEvent $event
	 */
	public function composeSubject() {
		// based on the given scenario, construct the appropriate subject
		$userName = Yii::app()->user->model->fullName;
		$label = $this->owner->getScenarioLabel($this->owner->scenario);
		$name = $this->owner->emailName;
		return "{$userName} {$label} {$name}";
	}

	/** 
	 * Send the email to all users
	 * @param MailMessage
	 * @param array of Users
	 */
	public function sendMessage($users, $subject, $viewPath, $viewData, $from) {
		$to = array();
		foreach($users as $user) {
			if(Yii::app()->params['ext.behaviors.model.EmailNotificationBehavior.notifyCurrentUser']
			 || strcasecmp($user->id, Yii::app()->user->id) != 0) {
				$to[] = $user->email;
			}
		}
		return Yii::app()->mailer->batchSend($to, $subject, $viewPath, $viewData, $from);
	}
}