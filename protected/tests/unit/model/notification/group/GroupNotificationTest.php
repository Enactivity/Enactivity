<?php
/**
 * Tests for updating group notification
 * @author hvuong
 */
class GroupNotificationTest extends DbTestCase
{
	
	/*
	 * Test for notification email after updating group
	 */
	
	public function testGroupNotificationUpdate()
	{
		$group = GroupFactory::insert();
		$user = UserFactory::insert();
		$groupUser = new GroupUser();
		
		$groupUser->insertGroupUser($group->id, $user->id);
		
		$newName = StringUtils::createRandomString(10);
		$group->setAttributes(array(
	    	'name' => $newName,
	    ));
	    
	    //set up a mock object
	    $messageMock = $this->getMock('MailMessage');
	    
		$mailerMock = $this->getMock('YiiMail', array('send', 'constructMessage'));
	
		//set up the test that the mock mailer will call send() once
		$mailerMock->expects($this->once())
			->method('send')
			->will($this->returnValue(true));
		$mailerMock->expects($this->any())
			->method('constructMessage')
			->will($this->returnValue($messageMock));
	
		Yii::app()->setComponent('mail', $mailerMock);
		
		$group->save();
	}
	
	public function testGroupNotificationSubject()
	{
		$subject = 'Psst. Something just happened on Poncla!';
		$group = GroupFactory::insert();
		$user = UserFactory::insert();
		$groupUser = new GroupUser();
		
		$groupUser->insertGroupUser($group->id, $user->id);
		
		$newName = StringUtils::createRandomString(10);
		$group->setAttributes(array(
	    	'name' => $newName,
	    ));
	    
	    //set up a mock object
	    $messageMock = $this->getMock('MailMessage');
	    
		$mailerMock = $this->getMock('YiiMail', array('send', 'constructMessage'));
	
		//set up the test that the mock mailer will call send() once
		$mailerMock->expects($this->once())
			->method('send')
			->will($this->returnValue(true));
		$mailerMock->expects($this->any())
			->method('constructMessage')
			->will($this->returnValue($messageMock));
		$messageMock->expects($this->once())
			->method('setSubject')
			->with($this->equalTo($subject));
	
		Yii::app()->setComponent('mail', $mailerMock);
	
		$group->save();
	}
	
	public function testGroupNotificationTo()
	{
		$group = GroupFactory::insert();
		$user = UserFactory::insert();
		$groupUser = new GroupUser();
		
		$groupUser->insertGroupUser($group->id, $user->id);
		
		$newName = StringUtils::createRandomString(10);
		$group->setAttributes(array(
	    	'name' => $newName,
	    ));
	    
	    //set up a mock object
	    $messageMock = $this->getMock('MailMessage');
	    
		$mailerMock = $this->getMock('YiiMail', array('send', 'constructMessage'));
	
		//set up the test that the mock mailer will call send() once
		$mailerMock->expects($this->once())
			->method('send')
			->will($this->returnValue(true));
		$mailerMock->expects($this->any())
			->method('constructMessage')
			->will($this->returnValue($messageMock));		
		$messageMock->expects($this->at(2))
			->method('setTo')
			->with($user->email);
	
		Yii::app()->setComponent('mail', $mailerMock);
		
		$this->assertTrue($group->save(), 'valid group was not saved: ' . CVarDumper::dumpAsString($group->getErrors()));
	}
	
	public function testGroupNotificationBody()
	{
		$group = GroupFactory::insert();
		$user = UserFactory::insert(array(), $group->id);
		
		$oldName = $group->name;
		$newName = StringUtils::createRandomString(10);
		$group->name = $newName;
	    
	    $expectedMessageText = 'Hey there. Just letting you know ' . Yii::app()->user->model->getFullName() . ' updated the name of your group to ' . $newName . '.';
	    
	    // message to test against
	    $mailMessage = new PMailMessage();
	    
	    //set up a mock object that constructs our message
		$mailerMock = $this->getMock('YiiMail', array('send', 'constructMessage'));

		$mailerMock->expects($this->any())
			->method('send')
			->will($this->returnValue(true));
		$mailerMock->expects($this->any())
			->method('constructMessage')
			->will($this->returnValue($mailMessage));

		Yii::app()->setComponent('mail', $mailerMock);
				
		$group->save();
		
		// TODO: have yii mail write to file then later open file to match string
		$this->assertContains($expectedMessageText, $mailMessage->body, 'Expected message not in email body');
	}
	
	protected function tearDown()
	{
		parent::tearDown();
		Yii::app()->setComponent("mail", null);
	}
	
}