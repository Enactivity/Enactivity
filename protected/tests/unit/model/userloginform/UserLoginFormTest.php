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
	
/*	public function testAuthenticateValid() {
		$email = $this->users['registered']['email'];
		$password = $this->users['registered']['password'];
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    $this->assertTrue($formUnderTest->validate(), 'valid user was marked as invalid');
	}

	public function testLoginValid() {
		$email = $this->users['registered']['email'];
		$password = $this->users['registered']['password'];
		$formUnderTest = new UserLoginForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email,
			'password' => $password,
	    ));
	    var_dump($formUnderTest->login());	
	}
*/	

}