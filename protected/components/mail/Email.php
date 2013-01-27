<?php
/**
* Email class file.
*
* @author Jonah Turnquist <poppitypop@gmail.com>
* @link https://code.google.com/p/yii-mail/
* @package Yii-Mail
*/

/**
* Any requests to set or get attributes or call methods on this class that are 
* not found in that class are redirected to the {@link Swift_Mime_Message} 
* object.
* 
* This means you need to look at the Swift Mailer documentation to see what 
* methods are availiable for this class.  There are a <b>lot</b> of methods, 
* more than I wish to document.  Any methods availiable in 
* {@link Swift_Mime_Message} are availiable here.
* 
* Documentation for the most important methods can be found at 
* {@link http://swiftmailer.org/docs/messages}
* 
* The Email component also allows using a shorthand for methods in 
* {@link Swift_Mime_Message} that start with set* or get*
* For instance, instead of calling $message->setFrom('...') you can use 
* $message->from = '...'.
* 
* Here are a few methods to get you started:
* <ul>
* 	<li>setSubject('Your subject')</li>
* 	<li>setFrom(array('john@doe.com' => 'John Doe'))</li>
* 	<li>setTo(array('receiver@domain.org', 'other@domain.org' => 'Name'))</li>
* 	<li>attach(Swift_Attachment::fromPath('my-document.pdf'))</li>
* </ul>
*/
class Email extends CComponent {

	/**
	* @var Swift_Mime_Message
	*/
	public $swiftMessage;

	/**
	* Any requests to set or get attributes or call methods on this class that 
	* are not found are redirected to the {@link Swift_Mime_Message} object.
	* @param string the attribute name
	*/
	public function __get($name) {
		try {
			return parent::__get($name);
		} catch (CException $e) {
			$getter = 'get'.$name;
			if(method_exists($this->swiftMessage, $getter))
				return $this->swiftMessage->$getter();
			else
				throw $e;
		}
	}

	/**
	* Any requests to set or get attributes or call methods on this class that 
	* are not found are redirected to the {@link Swift_Mime_Message} object.
	* @param string the attribute name
	*/
	public function __set($name, $value) {
		try {
			return parent::__set($name, $value);
		} catch (CException $e) {
			$setter = 'set'.$name;
			if(method_exists($this->swiftMessage, $setter))
				$this->swiftMessage->$setter($value);
			else
				throw $e;		
		}
	}

	/**
	* Any requests to set or get attributes or call methods on this class that 
	* are not found are redirected to the {@link Swift_Mime_Message} object.
	* @param string the method name
	*/
	public function __call($name, $parameters) {
		try {
			return parent::__call($name, $parameters);	
		} catch (CException $e) {
			if(method_exists($this->swiftMessage, $name))
				return call_user_func_array(array($this->swiftMessage, $name), $parameters);
			else
				throw $e;
		}
	}

	/**
	* You may optionally set some message info using the parameters of this 
	* constructor.
	* Use {@link view} and {@link setBody()} for more control.
	* 
	* @param string $subject
	* @param string $body
	* @param string $contentType
	* @param string $charset
	* @return Swift_Mime_Message
	*/
	public function __construct() {
		Yii::app()->mailer->registerScripts();
		$this->swiftMessage = Swift_Message::newInstance();
	}

	/**
	* Set the body of this entity, either as a string, or array of view 
	* variables if a view is set, or as an instance of 
	* {@link Swift_OutputByteStream}.
	* 
	* @param string view alias for body of email
	* @param array the data of the message.  If a $view is set and this 
	* is a string, this is passed to the view as $data.  If $view is set 
	* and this is an array, the array values are passed to the view like in the 
	* controller render() method
	* @param string content type optional. For html, set to 'text/html'
	* @param string charset optional
	*/
	public function setBody($view, $data = null, $contentType = 'text/html', $charset = 'utf-8') {
		
		// if Yii::app()->controller doesn't exist create a dummy 
		// controller to render the view (needed in the console app)
		if(isset(Yii::app()->controller)) {
			$controller = Yii::app()->controller;
		}
		else {
			$controller = new CController('Email');
		}

		$data = array_merge($data, array('email'=>$this)); // append email data to data
		
		// renderPartial won't work with CConsoleApplication, so use 
		// renderInternal - this requires that we use an actual path to the 
		// view rather than the usual alias
		$viewPath = Yii::getPathOfAlias(Yii::app()->mailer->viewPath.'.'.$view).'.php';
		$output = $controller->renderInternal($viewPath, $data, true);	

		return $this->swiftMessage->setBody($output, $contentType, $charset);
	}
}