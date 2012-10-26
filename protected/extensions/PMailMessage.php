<?php

Yii::import("application.components.mail.MailMessage");

//FIXME: Harrison explain what this class is for 
class PMailMessage extends CComponent implements MailMessage {
	
	public $view = "";
	public $message = "";
	public $from = "";
	public $to = array();
	public $subject = "";
	public $body = "";
	
	public function setBody($body = '', $contentType = null, $charset = null) {
		if ($this->view !== null) {
			if (!is_array($body)) $body = array('body'=>$body);
			
			// if Yii::app()->controller doesn't exist create a dummy 
			// controller to render the view (needed in the console app)
			if(isset(Yii::app()->controller))
				$controller = Yii::app()->controller;
			else
				$controller = new CController('YiiMail');
			
			// renderPartial won't work with CConsoleApplication, so use 
			// renderInternal - this requires that we use an actual path to the 
			// view rather than the usual alias
			$viewPath = Yii::getPathOfAlias(Yii::app()->mail->viewPath.'.'.$this->view).'.php';
			$body = $controller->renderInternal($viewPath, array_merge($body, array('mail'=>$this)), true);	
		}
		$this->body = $body;
		return true;
	}
	
	public function setFrom($from = '') {
		return true;
	}
	
	public function setSubject($subject = '') {
		return true;
	}
	
	public function setTo($email = '') {
		return true;
	}
	
}