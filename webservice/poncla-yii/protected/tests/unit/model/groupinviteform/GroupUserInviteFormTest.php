<?php
/**
 * @author hvuong
 */
class GroupUserInviteGroupTest extends DbTestCase
{
	
	/**
	 * Test submitting blank form
	 */
	
	public function testEmpty() {
		$email = ' ';
		$formUnderTest = new GroupInviteForm();
		$formUnderTest->setAttributes(array(
	        'emails' => $email
	    ));
	    $this->assertFalse($formUnderTest->validate(), 'empty email was marked as valid: ' . CVarDumper::dumpAsString($formUnderTest->errors));
		$this->assertFalse($formUnderTest->inviteUsers(), 'empty email was used for invitation');
	}
	
	/**
	 * Testing invalid email
	 * @expectedException CHttpException
	 */
	public function testInvalidEmail() {
		$email = StringUtils::createRandomString(20);
		$formUnderTest = new GroupInviteForm();
		$formUnderTest->setAttributes(array(
			'emails' => $email
		));
		$this->assertFalse($formUnderTest->validate(), 'invalid email string was marked as valid: ' . CVarDumper::dumpAsString($formUnderTest->errors));
		
		$formUnderTest->inviteUsers();	
	}
	
	/**
	 * Testing single valid email invite
	 */

	
	public function testSingleEmailInvite() {
		$group = GroupFactory::insert();
		
		$email = StringUtils::createRandomEmail();
		$formUnderTest = new GroupInviteForm();
		$formUnderTest->setAttributes(array(
			'emails' => $email,
			'groupId' => $group->id,
		));
		$this->assertTrue($formUnderTest->validate(), 'valid email was marked as invalid');
		
		// set up a mock object
		Yii::import('application.extensions.mailer.Mailer');
		$mailerMock = $this->getMock('Mailer', array('send'));
		
		// set up the test that the mock mailer will call send() once
		$mailerMock->expects($this->once())
			->method('send');
			
		Yii::app()->setComponent('mailer', $mailerMock);
		
		$this->assertTrue($formUnderTest->inviteUsers(), "valid single email was not sent: " . CVarDumper::dumpAsString($formUnderTest->errors));
		
	}

	
	/**
	 * Testing multiple valid email invites
	 */
	
	public function testMultipleValidEmailInvites()
	{
		$group = GroupFactory::insert();
		
		$emails = StringUtils::createRandomEmail();
		$emails .= "," . StringUtils::createRandomEmail();
		$emails .= "," .  StringUtils::createRandomEmail();
		
		$formUnderTest = new GroupInviteForm();
		$formUnderTest->setAttributes(array(
			'emails' => $emails,
		    'groupId' => $group->id,
		));
		
		// set up a mock object
		Yii::import('application.extensions.mailer.Mailer');
		$mailerMock = $this->getMock('Mailer', array('send'));
		
		// set up the test that the mock mailer will call send() once
		$mailerMock->expects($this->exactly(3))
			->method('send');
			
		Yii::app()->setComponent('mailer', $mailerMock);
		
		$this->assertTrue($formUnderTest->inviteUsers(), "valid multiple emails were not sent: " . CVarDumper::dumpAsString($formUnderTest->errors));
		
	}
	
	/**
	 * Testing multiple invalid email invites with single valid email
	 */
	
	public function testMultipleInvalidEmailInvitesWithSingleValidEmail()
	{
		$group = GroupFactory::insert();
		
		$emails = StringUtils::createRandomString(20);
		$emails .= "," . StringUtils::createRandomEmail();
		$emails .= "," .  StringUtils::createRandomString(20);
		
		$formUnderTest = new GroupInviteForm();
		$formUnderTest->setAttributes(array(
			'emails' => $emails,
		    'groupId' => $group->id,
		));
		
		$this->assertFalse($formUnderTest->validate(), "invalid multiple emails were marked as valid: " . CVarDumper::dumpAsString($formUnderTest->errors));
		
	}
	
	/**
	 * Testing multiple valid email invites with single invalid email
	 */

	public function testMultipleValidEmailInvitesWithSingleInvalidEmail()
	{
		$group = GroupFactory::insert();
		
		$emails = StringUtils::createRandomString(20);
		$emails .= "," . StringUtils::createRandomEmail();
		$emails .= "," .  StringUtils::createRandomString(20);
		
		$formUnderTest = new GroupInviteForm();
		$formUnderTest->setAttributes(array(
			'emails' => $emails,
		    'groupId' => $group->id,
		));
		
		$this->assertFalse($formUnderTest->validate(), "invalid multiple email was marked as valid: " . CVarDumper::dumpAsString($formUnderTest->errors));
		
	}

	
}

