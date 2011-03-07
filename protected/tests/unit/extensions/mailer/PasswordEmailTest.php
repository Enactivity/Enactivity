<?php
/**
 * Unit test for Mailer extension, PasswordEmail child class
 * @author Long Huynh
 */

Yii::import('application.extensions.mailer.PasswordEmail');

class PasswordEmailTest extends PHPUnit_Framework_TestCase {

	public function testSendIsCalled() {
		$to = StringUtils::createRandomString(30);
		$newPassword = StringUtils::createRandomString(10);
		$sendTest = true;
		
		$testClass = new PasswordEmail;
		$testClass->to = $to;
		$testClass->newpassword = $newPassword;
		$testClass->sendTest = $sendTest;
		$testClass->send();
	}

	public function testExceptionTo() {
        try {
			$to = null;
		
			$testClass = new PasswordEmail;
			$testClass->send();
        }
        catch (Exception $expected) {
            return;
        }
    
        $this->fail('Attempted to send email with no destination in PasswordEmail');
	}
	
	public function testExceptionNewPassword() {
        try {
        	$to = StringUtils::createRandomString(30);
			$newPassword = null;
		
			$testClass = new PasswordEmail;
			$testClass->to = $to;
			$testClass->newpassword = $newPassword;
			$testClass->send();
        }
        catch (Exception $expected) {
            return;
        }
    
        $this->fail('Value newpassword not being passed into PasswordEmail');
	}
}