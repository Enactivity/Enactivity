<?php
/**
 * Contains various elements for the password recovery email.
 * @author Long Huynh
 */

Yii::import('application.extensions.mailer.Mailer');

class PasswordEmail extends Mailer {
	/**
	 * @var string The user's new password.
	 */
	public $newpassword = null;

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
			("Attempted to send email with no destination in PasswordEmail");
		}

		if ($this->newpassword == null) {
			throw new Exception ("Value newpassword not being passed into PasswordEmail");
		}
				
		$this->from = "no-reply@" . Yii::app()->request->serverName;
		$subject = 'Your Poncla password has been reset';
		$body = 'Someone has requested that your password for your account'
			. ' be reset.  We\'ve generated the new password: '
			. $this->newpassword . ' for you.  You can change it once you log in.'
			. '  If you didn\'t request this new password please contact us at'
			. ' info@' . Yii::app()->request->serverName;

		return $this->transmit($to, $from, $subject, $body);
	}
}
