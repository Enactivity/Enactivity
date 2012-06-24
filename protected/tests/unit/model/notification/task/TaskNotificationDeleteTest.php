<?php
/**
 * Tests for updating group notification
 * @author hvuong
 */
class TaskNotificationDeleteTest extends DbTestCase
{
	
	/*
	 * Test for notification email after updating group
	 */
	
	public function testTaskNotificationDeleteBody()
	{		
		$group = GroupFactory::insert();
		$task = TaskFactory::insert(array(), $group->id);
		$userA = UserFactory::insert(array(), $group->id);
		$task->participate($userA->id);
		
		$expectedMessageText = 'Aww. ' . Yii::app()->user->model->getFullName() . ' deleted ' . $task->name . '.';
		
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
					
		$task->deleteNode();
					
		$this->assertContains($expectedMessageText, $mailMessage->body, 'Expected message not in email body');
		
	}

	protected function tearDown()
	{
		parent::tearDown();
		Yii::app()->setComponent("mail", null);
	}
	
}