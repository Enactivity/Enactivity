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
	 * @var string Declares what mail transfer agent to use to send the emails.
	 * Only valid value right now is php.
	 */
	public $mailTransferAgent = 'php';
	
	/**
	 * @var boolean Test flag.  Enable to print to screen instead of actually mailing.
	 */
	public $shouldEmail = false;
	
	/**
	 * Converts an array to a comma delimited string
	 * @param array Array values to be converted.
	 * @return string Converted values.
	 */
	protected function convertArrayToString($array) {
		return (is_array($array)) ? implode(', ', $array) : $array;
	}

	/**
	 * Create the email headers.
	 * @return array Email headers.
	 */
	protected function createHeaders() {
		$headers = array();
		
		if ($this->messageId == null) {
			$this->messageId = date('ymd.His\@') . Yii::app()->request->serverName;
		}

		$headers[] = "Message-Id: <{$this->messageId}>";
		$headers[] = "From: {$this->convertArrayToString($this->from)};";
		$headers[] = "Content-Type: {$this->contentType};";
		$headers[] = "MIME-Version: {$this->mime};";
		
		return $headers;
	}

	/**
	 * Perform some processing before transmitting the email.
	 * @return boolean Result of email transmission.
	 */
	public function send($obj) {
		return $obj->send();
	}
	
	/**
	 * Transmit the email to intented recipent.
	 * @param string Recipient.
	 * @param string Originator.
	 * @param string Subject line.
	 * @param string Message.
	 * @return boolean Result of email transmission.
	 */
	protected function transmit($to, $from, $subject, $body) {
		if (!$this->shouldEmail) {	
			//Temp fix while I learn about views
			Yii::log("Mailer shouldEmail logged output\nHeaders: "
				. implode("\r\n", $this->createHeaders()) . "\nTo: " . $to . "\n"
				. "Subject: " . $subject . "\nBody: " . $body,
				'info',
				'application.extensions.Mailer'
			);
		}
		else {
			switch ($this->mailTransferAgent) {
				case 'php':
					$subject = wordwrap($subject, $this->maxLength);
					$body = wordwrap($body, $this->maxLength);
					$from = $this->from;
					return mail($to, $subject, $body, implode("\r\n", $this->createHeaders()));
					break;
				default:
					throw new Exception
					("Unexpected Mail Transfer Agent selected in Mailer");
			}
		}
	}
}