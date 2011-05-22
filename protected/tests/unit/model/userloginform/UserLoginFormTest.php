<?php

require_once 'TestConstants.php';

class UserLoginFormTest extends DbTestCase
{
	public function testEmptyForm() {
		$email = '';
		$password = '';
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertFalse($formUnderTest->validate(), 'empty form was marked as valid');
	}
	
	public function testEmptyEmail() {
		$email = '';
		$password = $this->userFixtures['registered']['password'];
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertFalse($formUnderTest->validate(), 'empty email was marked as valid');
	}

	public function testEmptyPassword() {
		$email = $this->userFixtures['registered']['email'];
		$password = '';
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertFalse($formUnderTest->validate(), 'empty password was marked as valid');
	}

	public function testLoginValidAdmin() {
		$email = $this->userFixtures['admin']['email'];
		$password = 'test';
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertTrue($formUnderTest->login(), 'valid user was unable to log in');
	}

	public function testLoginInvalid() {
		$email = $this->userFixtures['admin']['email'];
		$password = StringUtils::createRandomString(30);
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertFalse($formUnderTest->login(), 'invalid user was able to log in');
	}
	
	
}

/* AFONG TODO: 
 * testLoginValidMember()
 * testLoginInactive()
 * testLoginBanned()
 */