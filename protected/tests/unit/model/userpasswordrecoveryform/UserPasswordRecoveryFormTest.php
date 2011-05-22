<?php

require_once 'TestConstants.php';

class UserPasswordRecoveryTest extends DbTestCase
{	
	public function testEmpty() {
		$email = '';
		$formUnderTest = new UserPasswordRecoveryForm();
		$formUnderTest->setAttributes(array(
	        'email' => $email
	    ));
	    $this->assertFalse($formUnderTest->validate(), 'empty email was marked as valid');
	}
	
	public function testInvalidEmail() {
		$email = StringUtils::createRandomString(30);
		$formUnderTest = new UserPasswordRecoveryForm();
		$formUnderTest->setAttributes(array(
			'email' => $email
		));
		$this->assertTrue($formUnderTest->validate(), 'email string was not able to validate');
		$this->assertEmpty($formUnderTest->recoverPassword(), 'invalid email was used to recover');	
	}

/*	public function testValidEmail() {
		$email = $this->userFixtures['registered']['email'];
		$formUnderTest = new UserPasswordRecoveryForm();
		$formUnderTest->setAttributes(array(
			'email' => $email
		));
		$updatedUser = User::model()->findByPk($this->userFixtures['registered']['id']);
		var_dump($updatedUser->email);
		var_dump($formUnderTest->recoverPassword());
		$this->assertTrue($formUnderTest->recoverPassword(), 'valid email was not able to recover');	
	}
*/	
	
}