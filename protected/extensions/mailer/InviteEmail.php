<?php
/**
 * Contains various elements for the invitation email.
 * @author Long Huynh
 */

Yii::import('application.extensions.mailer.Mailer');

class InviteEmail extends Mailer {
	/**
	 * @var string The originating user who initiated the invitation.
	 */
	public $userName = null;

	/**
	 * @var string The group the user is invited to.
	 */
	public $groupName = null;

	/**
	 * @var string Unique identifier so that we know they have accepted the invitation.
	 */
	public $token = null;

	/**
	 * Perform some processing before transmitting the email.
	 * @return boolean Result of email transmission.
	 */
	public function send() {
		if ($this->to != null) {
			$to = $this->convertArrayToString($this->to);
		}
		else {
			throw new Exception
			("Attempted to send email with no destination in InviteEmail");
		}

		if ($this->userName == null ||
			$this->groupName == null ||
			$this->token == null) {
			throw new Exception
			("Values username, groupname, or token not being passed into InviteEmail");
		}

		$from = "no-reply@" . Yii::app()->request->serverName;
		$subject = "{$this->userName} invites you to join {$this->groupName} on Poncla";
		$body = $this->userName . " has invited you to join the {$this->groupName} group"
			. " on Poncla. To accept this invitation, go to "
			. Yii::app()->request->hostInfo . "/index.php/user/register?token="
			. $this->token . " and complete your registration.";

		return $this->transmit($to, $from, $subject, $body);
	}
}