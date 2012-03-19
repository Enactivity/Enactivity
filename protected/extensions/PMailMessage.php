<?php
class PMailMessage extends CComponent implements MailMessage {
	
	public $view = "";
	public $message = "";
	public $from = "";
	public $to = array();
	public $subject = "";
	public $body = "";
	
	public function setBody($body = '', $contentType = null, $charset = null) {
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