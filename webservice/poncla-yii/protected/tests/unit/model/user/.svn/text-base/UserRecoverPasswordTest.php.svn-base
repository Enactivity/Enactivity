<?php
/**
 * Tests for User::RecoverPassword
 * @author ajsharma
 */
class UserRecoverPasswordTest extends DbTestCase
{
	/**
	 * Test that recoverPassword changes password  
	 */
	public function testRecoverPasswordChangesPassword() {
		$user = UserFactory::insert();
		$oldPassword = $user->password;
		
		$this->assertTrue($user->recoverPassword(), "Recover password returned false");
		$this->assertNotEquals($oldPassword, $user->password, "Recover password did not change password");
	}
	
	/**
	 * Test that recovering password set the user model's scenario 
	 */
	public function testRecoverPasswordSetsScenario() {
		$user = UserFactory::insert();
		$user->recoverPassword();
		
		$this->assertEquals(User::SCENARIO_RECOVER_PASSWORD, $user->scenario, "Recovering password did not set scenario");
	}
	
	/**
	 * Test that recovering password sends an email  
	 */
	public function testRecoverPasswordSendsEmail() {
		// set up a mock object
		$mailerMock = $this->getMock('Mailer', array('send'));
		
		// set up the test that the mock mailer will call send() once
		$mailerMock->expects($this->once())
			->method('send');
		
		Yii::app()->setComponent('mailer', $mailerMock);
		
		$user = UserFactory::insert();
		$user->recoverPassword();
	}
}