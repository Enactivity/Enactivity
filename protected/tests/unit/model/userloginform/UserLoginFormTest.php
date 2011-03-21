<?php

require_once 'TestConstants.php';

class UserLoginFormTest extends DbTestCase
{
	public $fixtures = array(
		'users'=>'User',
	);
	
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
		$password = $this->users['registered']['password'];
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertFalse($formUnderTest->validate(), 'empty email was marked as valid');
	}

	public function testEmptyPassword() {
		$email = $this->users['registered']['email'];
		$password = '';
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertFalse($formUnderTest->validate(), 'empty password was marked as valid');
	}

	//TODO: Password should not be hard coded	
	public function testLoginValid() {
		$email = $this->users['admin']['email'];
		$password = 'test';
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertTrue($formUnderTest->login(), 'valid user was unable to log in');
	}

	public function testLoginInvalid() {
		$email = $this->users['admin']['email'];
		$password = StringUtils::createRandomString(30);
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertFalse($formUnderTest->login(), 'invalid user was able to log in');
	}
}