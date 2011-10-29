<?php
/**
 * Tests for User::SendInvitation
 * @author ajsharma
 */
class UserSendInvitationTest extends DbTestCase
{
	/**
	 * Test that send invitation sends email
	 */
	public function testSendInvitation() {
		// setup
		$inviter = UserFactory::insert();
		$group = GroupFactory::insert();
		
		// set up a mock object
		$mailerMock = $this->getMock('Mailer', array('send'));
		
		// set up the test that the mock mailer will call send() once
		$mailerMock->expects($this->once())
			->method('send')
			->with($this->anything())
			->will($this->returnValue(true));
		Yii::app()->setComponent('mailer', $mailerMock);
		
		$this->assertTrue($inviter->sendInvitation($inviter->fullName, $group->name), "sending invite did not return true");
	}
	
	/**
	* Test that send invitation sends email
	*/
	public function testSendInvitationSendsEmail() {
		// setup
		$inviter = UserFactory::insert();
		$group = GroupFactory::insert();
	
		// set up a mock object
		$mailerMock = $this->getMock('Mailer', array('send'));
	
		// set up the test that the mock mailer will call send() once
		$mailerMock->expects($this->once())
			->method('send')
			->will($this->returnValue(true));
	
		Yii::app()->setComponent('mailer', $mailerMock);
		$inviter->sendInvitation($inviter->fullName, $group->name);
	}
}