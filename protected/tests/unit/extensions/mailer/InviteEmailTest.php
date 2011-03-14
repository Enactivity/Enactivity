<?php
/**
 * Unit test for Mailer extension, InviteEmail child class
 * @author Long Huynh
 */

Yii::import('application.extensions.mailer.InviteEmail');

class InviteEmailTest extends PHPUnit_Framework_TestCase {

	public function testSendIsCalled() {
		$to = StringUtils::createRandomString(30);
		$userName = StringUtils::createRandomString(30);
		$groupName = StringUtils::createRandomString(30);
		$token = StringUtils::createRandomString(40);
		$shouldEmail = true;
		
		$testClass = new InviteEmail;
		$testClass->to = $to;
		$testClass->userName = $userName;
		$testClass->groupName = $groupName;
		$testClass->token = $token;
		$testClass->shouldEmail = $shouldEmail;
		$testClass->send();
	}
	
	public function testExceptionTo() {
        try {
			$to = null;
		
			$testClass = new InviteEmail;
			$testClass->send();
        }
        catch (Exception $expected) {
            return;
        }
    
        $this->fail('Attempted to send email with no destination in InviteEmail');
	}
	
	public function testExceptionUserName() {
        try {
        	$to = StringUtils::createRandomString(30);
			$userName = null;
			$groupName = StringUtils::createRandomString(30);
			$token = StringUtils::createRandomString(40); 
		
			$testClass = new InviteEmail;
			$testClass->to = $to;
			$testClass->userName = $userName;
			$testClass->groupName = $groupName;
			$testClass->token = $token;
			$testClass->send();
        }
        catch (Exception $expected) {
            return;
        }
    
        $this->fail('Values username, groupname, or token not being passed into InviteEmail');
	}
	
	public function testExceptionGroupName() {
        try {
        	$to = StringUtils::createRandomString(30);
			$userName = StringUtils::createRandomString(30);
			$groupName = null;
			$token = StringUtils::createRandomString(40); 
		
			$testClass = new InviteEmail;
			$testClass->to = $to;
			$testClass->userName = $userName;
			$testClass->groupName = $groupName;
			$testClass->token = $token;
			$testClass->send();
        }
        catch (Exception $expected) {
            return;
        }
    
        $this->fail('Values username, groupname, or token not being passed into InviteEmail');
	}
	
	public function testExceptionToken() {
        try {
        	$to = StringUtils::createRandomString(30);
			$userName = StringUtils::createRandomString(30);
			$groupName = StringUtils::createRandomString(30);
			$token = null; 
		
			$testClass = new InviteEmail;
			$testClass->to = $to;
			$testClass->userName = $userName;
			$testClass->groupName = $groupName;
			$testClass->token = $token;
			$testClass->send();
        }
        catch (Exception $expected) {
            return;
        }
    
        $this->fail('Values username, groupname, or token not being passed into InviteEmail');
	}
}