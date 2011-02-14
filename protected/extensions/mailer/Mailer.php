<?php
/**
 * Mailer sends out emails using PHPmailer and can handle various
 * transactions such as registration, passwords requests, and notifications.
 * @author Long Huynh
 */
class Mailer extends CApplicationComponent {
	/**
	 * @var string Creates a unique identification for each email by
	 * providing a date and time stamp for each email sent, as recommended by RFC 2822.
	 */
	public $messageId = null;
	
	/**
	 * @var string The originator of the email.  To be set depending on the
	 * template type as certain email transactions may require different originators.
	 * For example, invitations may come from invite@poncla.com and password requests
	 * may come from password-request@poncla.com.
	 */
	public $from = null;
	
	/**
	 * @var string The email's final destination.
	 */
	public $to = null;
	
	/**
	 * @var string The descriptive summary for the email.  To be set
	 * depending on the template type.
	 */
	public $subject = '';

	/**
	 * @var integer Maximum length allowed for a line.
	 */
	public $maxLength = 70;
	
	/**
	 * @var string Standard email header declaration.
	 */
	public $mime = '1.0';
	
	/**
	 * @var string Set the expected type of email content.  For now
	 * it is only plain text.
	 */
	public $contentType = 'text/plain';
	
	/**
	 * @var string Email content.  To be set depending on the template type.
	 */
	public $body = '';
	
	/**
	 * @var string Determines what email to send.
	 */
	public $template = '';

	/**
	 * @var string Declares what mail transfer agent to use to send the emails.
	 * Only valid value right now is php.
	 */
	public $mta = 'php';
	
	/**
	 * @var array Array of extra info to include in the email.
	 */
	public $extraInfo = array();
	
	/**
	 * @var boolean Test flag.  Enable to print to screen instead of actually mailing.
	 */
	public $sendTest = false;
	
	/**
	 * Converts an array to a comma delimited string
	 * @param array Array values to be converted.
	 * @return string Converted values.
	 */
	private function convertArrayToString($array) {
		return (is_array($array)) ? implode(', ', $array) : $array;
	}

	/**
	 * Create the email headers.
	 * @return array Email headers.
	 */
	private function createHeaders() {
		$headers = array();
		
		if ($this->messageId == null) {
			$this->messageId = date('ymd.His\@') . Yii::app()->request->serverName;
		}

		$headers[] = "Message-Id: <{$this->messageId};>";
		$headers[] = "From: {$this->convertArrayToString($this->from)};";
		$headers[] = "Content-Type: {$this->contentType};";
		$headers[] = "MIME-Version: {$this->mime};";
		
		return $headers;
	}
	
	/**
	 * Perform some processing before transmitting the email.
	 * @return boolean Result of email transmission.
	 */
	public function send() {
		$to = $this->convertArrayToString($this->to);
		
		switch ($this->template) {
			case 'invitation':
				if ($this->extraInfo['userName'] == null ||
					$this->extraInfo['groupName'] == null ||
					$this->extraInfo['token'] == null) {
					throw new Exception
					("Values username or groupname not being passed into Mailer");
				}
				
				$this->from = "no-reply@" . Yii::app()->request->serverName;
				$subject = "{$this->extraInfo['userName']} invites you to join {$this->extraInfo['groupName']} on Poncla";
				$body = $this->extraInfo['userName'] . " has invited you to join the {$this->extraInfo['groupName']} group on"
					. " Poncla. To accept this invitation, go to "
					. Yii::app()->request->hostInfo . "/index.php/user/register?token=" . $this->extraInfo['token'] 
					. " and complete your registration.";
				break;
			case 'password':
				if ($this->extraInfo['newpassword'] == null) {
					throw new Exception ("Value newpassword not being passed into Mailer");
				}
				
				$this->from = "no-reply@". Yii::app()->request->serverName;
				$subject = 'Your Poncla password has been reset';
				$body = 'Someone has requested that your password for your account'
					. ' be reset.  We\'ve generated the new password: ' . $this->extraInfo['newpassword']
					. ' for you.  You can change it once you log in.  If you didn\'t request'
					. ' this new password please contact us at info@'. Yii::app()->request->serverName;
				break;
			default:
				throw new Exception ("Unexpected template selected in Mailer");
		}
		
		return $this->transmit($to, $from, $subject, $body, $this->sendTest);
	}

	/**
	 * Transmit the email to intented recipent.
	 * @param string Recipient.
	 * @param string Originator.
	 * @param string Subject line.
	 * @param string Message.
	 * @return boolean Result of email transmission.
	 */
	private function transmit($to, $from, $subject, $body, $sendTest) {
		switch ($this->mta) {
			case 'php':
				$subject = wordwrap($subject, $this->maxLength);
				$body = wordwrap($body, $this->maxLength);
				
				if (!$this->sendTest) {
					return mail($to, $subject, $body, implode("\r\n", $this->createHeaders()));
				}
				elseif ($this->sendTest) {	
					//Temp fix while I learn about views
					Yii::log("Mailer sendTest logged output\nHeaders: "
						. implode("\r\n", $this->createHeaders()) . "\nTo: " . $to . "\n"
						. "Subject: " . $subject . "\nBody: " . $body,
						'info',
						'application.extensions.Mailer'
					);
				}
				else {
					throw new Exception ("Unexpected value for variable sendTest in Mailer");
				}
				break;
			default:
				throw new Exception ("Unexpected MTA selected in Mailer");
		}
	}
}