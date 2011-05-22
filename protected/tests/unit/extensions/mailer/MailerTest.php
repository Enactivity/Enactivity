<?php
/**
 * Unit test for Mailer extension, Mailer parent class
 * PasswordEmail arbitrarily chosen as the type of Mailer to test send()
 * @author Long Huynh
 */

Yii::import('application.extensions.mailer.Mailer');
Yii::import('application.extensions.mailer.PasswordEmail');

class MailerTest extends PHPUnit_Framework_TestCase {
	
	public function testSendIsCalled() {	
		$to = StringUtils::createRandomString(30);
		$newpassword = StringUtils::createRandomString(10);
		
		$childClass = $this->getMock('PasswordEmail');
		$childClass->to = $to;
		$childClass->newpassword = $newpassword;
		$childClass->expects($this->once())->method('send');
					
		$testClass = new Mailer;
		$testClass->send($childClass);
	}
	
	public function testTransmit() {
		$to = StringUtils::createRandomString(30);
		$newPassword = StringUtils::createRandomString(10);
		$shouldEmail = false;
		
		$testClass = new PasswordEmail;
		$testClass->to = $to;
		$testClass->newpassword = $newPassword;
		$testClass->shouldEmail = $shouldEmail;

		//Commented out since this will generate an error
		//when a mail transport has not be installed
		//$testClass->send();
	}
}