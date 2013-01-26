<?php
/**
* Mailer class file.
*
* @author Jonah Turnquist <poppitypop@gmail.com>
* @link https://code.google.com/p/yii-mail/
* @package Yii-Mail
*/

Yii::import("application.components.mail.Email");

/**
* Mailer is an application component used for sending email.
*
* You may configure it as below.  Check the public attributes and setter
* methods of this class for more options.
* <pre>
* return array(
* 	...
* 	'import => array(
* 		...
* 		'ext.mail.MailerMessage',
* 	),
* 	'components' => array(
* 		'mail' => array(
* 			'class' => 'ext.yii-mail.Mailer',
* 			'transportType' => 'php',
* 			'viewPath' => 'application.views.mail',
* 			'logging' => true,
* 			'enabled' => false
* 		),
* 		...
* 	)
* );
* </pre>
* 
* Example usage:
* <pre>
* $email = new Email;
* $email->setBody('Message content here with HTML', 'text/html');
* $email->subject = 'My Subject';
* $email->addTo('johnDoe@domain.com');
* $email->from = Yii::app()->params['adminEmail'];
* Yii::app()->mail->send($email);
* </pre>
*/
class Mailer extends CApplicationComponent
{
	/**
	* @var bool whether to log messages using Yii::log().
	* Defaults to true.
	*/
	public $logging = true;
	
	/**
	* @var bool whether to disable actually sending mail.
	* Defaults to false.
	*/
	public $enabled = true;
	
	/**
	* @var string the delivery type.  Can be either 'php' or 'smtp'.  When 
	* using 'php', PHP's {@link mail()} function will be used.
	* Defaults to 'php'.
	*/
	public $transportType = 'php';
	
	/**
	* @var string the path to the location where mail views are stored.
	* Defaults to 'application.views.mail'.
	*/
	public $viewPath = 'application.views.mail';

	/** 
	 * @var string path to location of main Swift autoloader file
	 **/
	public $swift = 'ext.vendors.swiftMailer.classes.Swift';

	/** 
	 * @var string path to location of SwiftMailer's init 
	 **/ 
	public $swiftInit = 'ext.vendors.swiftMailer.swift_init';
	
	/**
	* @var string options specific to the transport type being used.
	* To set options for STMP, set this attribute to an array where the keys 
	* are the option names and the values are their values.
	* Possible options for SMTP are:
	* <ul>
	* 	<li>host</li>
	* 	<li>username</li>
	* 	<li>password</li>
	* 	<li>port</li>
	* 	<li>encryption</li>
	* 	<li>timeout</li>
	* 	<li>extensionHandlers</li>
	* </ul>
	* See the SwiftMailer documentaion for the option meanings.
	*/
	public $transportOptions;
	
	/**
	* @var mixed Holds the SwiftMailer transport
	*/
	protected $transport;

	/**
	* @var mixed Holds the SwiftMailer mailer
	*/
	protected $swiftMailer;

	/** 
	 * @var boolean whether scripts are registered or not
	 */
	private static $registeredScripts = false;

	/**
	* Calls the {@link registerScripts()} method.
	*/
	public function init() {
		$this->registerScripts();
		parent::init();	
	}
	
	/**
	* Send a {@link MailerMessage} as it would be sent in a mail client.
	* 
	* All recipients (with the exception of Bcc) will be able to see the other
	* recipients this message was sent to.
	* 
	* If you need to send to each recipient without disclosing details about the
	* other recipients see {@link batchSend()}.
	* 
	* Recipient/sender data will be retreived from the {@link MailerMessage} 
	* object.
	* 
	* The return value is the number of recipients who were accepted for
	* delivery.
	* 
	* @param MailMessage $email
	* @param array &$failedRecipients, optional
	* @return int
	* @see batchSend()
	*/
	public function send($email, &$failedRecipients = null) {
		if ($this->logging) {
			self::log($email);
		}
		
		if ($this->enabled) {
			return $this->getMailer()->send($email->swiftMessage, $failedRecipients);
		}
		return count($email->to);
	}

	/**
	* Send the given {@link MailerMessage} to all recipients individually.
	* 
	* This differs from {@link send()} in the way headers are presented to the 
	* recipient.  The only recipient in the "To:" field will be the individual 
	* recipient it was sent to.
	* 
	* If an iterator is provided, recipients will be read from the iterator 
	* one-by-one, otherwise recipient data will be retreived from the 
	* {@link MailerMessage} object.
	* 
	* Sender information is always read from the {@link MailerMessage} object.
	* 
	* The return value is the number of recipients who were accepted for 
	* delivery.
	* 
	* @param MailerMessage $email
	* @param array &$failedRecipients, optional
	* @param Swift_Mailer_RecipientIterator $it, optional
	* @return int
	* @see send()
	*/
	protected function batchSendEmail($email, &$failedRecipients = null, Swift_Mailer_RecipientIterator $it = null) {
		if ($this->logging) {
			self::log($email);
		}
		if ($this->enabled) {
			return $this->getMailer()->batchSend($email->swiftMessage, $failedRecipients, $it);
		}
		return count($email->to);
	}

	/** 
	 * @param array emails
	 * @param string
	 * @param string 
	 * @param array data
	 * @param string
	 **/
	public function batchSend($to, $subject, $view, $data, $from) {

		$email = new Email();
		$email->to = $to;
		$email->subject = $subject;
		$email->setBody($view, $data);
		$email->from = $from;

		return $this->batchSendEmail($email);
	}

	/**
	* Logs a MailerMessage in a (hopefully) readable way using Yii::log.
	* @return string log message
	*/
	public static function log($email) {
		$msg = 'Sending email to '.implode(', ', array_keys($email->to))."\n".
			implode('', $email->headers->getAll())."\n".
			$email->body
		;
		Yii::log($msg, CLogger::LEVEL_INFO, 'ext.yii-mail.Mailer'); // TODO: attempt to determine alias/category at runtime
		return $msg;
	}

	/**
	* Gets the SwiftMailer transport class instance, initializing it if it has 
	* not been created yet
	* @return mixed {@link Swift_MailTransport} or {@link Swift_SmtpTransport}
	*/
	public function getTransport() {
		if ($this->transport===null) {
			switch ($this->transportType) {
				case 'php':
					$this->transport = Swift_MailTransport::newInstance();
					if ($this->transportOptions !== null)
						$this->transport->setExtraParams($this->transportOptions);
					break;
				case 'smtp':
					$this->transport = Swift_SmtpTransport::newInstance();
					foreach ($this->transportOptions as $option => $value)
						$this->transport->{'set'.ucfirst($option)}($value); // sets option with the setter method
					break;
			}
		}
		
		return $this->transport;
	}
	
	/**
	* Gets the SwiftMailer {@link Swift_Mailer} class instance
	* @return Swift_Mailer
	*/
	public function getMailer() {
		if (is_null($this->swiftMailer)) {
			$this->swiftMailer = Swift_Mailer::newInstance($this->getTransport());
		}
			
		return $this->swiftMailer;
	}
	
    /**
    * Registers swiftMailer autoloader and includes the required files
    */
    public function registerScripts() {
    	if (self::$registeredScripts) {
    		return;
    	}
    	self::$registeredScripts = true;
    	
		Yii::import($this->swift, true);
		Yii::registerAutoloader(array('Swift','autoload'));
		Yii::import($this->swiftInit, true);
	}
}