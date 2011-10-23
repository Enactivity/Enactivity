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
		$password = USER_PASSWORD;
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertFalse($formUnderTest->validate(), 'empty email was marked as valid');
	}

	public function testEmptyPassword() {
		$email = USER_EMAIL;
		$password = '';
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertFalse($formUnderTest->validate(), 'empty password was marked as valid');
	}

	public function testLoginValidAdmin() {
		$email = ADMIN_EMAIL;
		$password = ADMIN_PASSWORD;
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertTrue($formUnderTest->login(), 'valid user was unable to log in');
	}

	public function testLoginInvalid() {
		$email = ADMIN_EMAIL;
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