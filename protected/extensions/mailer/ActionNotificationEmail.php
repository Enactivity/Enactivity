<?php
/**
 * Contains various elements for the invitation email.
 * @author Long Huynh
 */

Yii::import('application.extensions.mailer.Mailer');

class ActionNotificationEmail extends Mailer {
	
	/**
	 * Perform some processing before transmitting the email.
	 * @return boolean Result of email transmission.
	 */
	public function send() {
		$this->from = "no-reply@" . Yii::app()->request->serverName;
		$subject = "{$this->userName} invites you to join {$this->groupName} on " . Yii::app()->name;
		$body = $this->userName . " has invited you to join the {$this->groupName} group"
			. " on " . Yii::app()->name . ". To accept this invitation, go to "
			. Yii::app()->request->hostInfo . "/index.php/user/register?token="
			. $this->token . " and complete your registration.";

		return $this->transmit($to, $from, $subject, $body);
	}
}