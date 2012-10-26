<?php
interface MailMessage {
	
	public function setBody($body = '', $contentType = null, $charset = null);
	
	public function setFrom($from = '');
		
	public function setSubject($subject = '');
	
	public function setTo($email = '');
	
}