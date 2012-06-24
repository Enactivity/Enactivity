<?php
/**
 * Tests for updating group notification
 * @author hvuong
 */
class TaskNotificationInsertTest extends DbTestCase
{
	
	/*
	 * Test for notification email after updating group
	 */
	
	public function testTaskNotificationInsertBody()
	{
		$id = 42;
		$name = "test task";
		$isTrash = 0;
		$created = date ("Y-m-d H:i:s", strtotime("-1 hours"));
		$modified = date ("Y-m-d H:i:s", strtotime("-1 hours"));

		$task = new Task();

		$task->attributes = array(
			'id' => $id,
			'name' => $name,
			'isTrash' => $isTrash,
			'created' => $created,
			'modified' => $modified,
		);
		
		$expectedMessageText = 'Fantastic! ' . Yii::app()->user->model->getFullName() . ' created ' . $task->name . '.';
		
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
					
		$task->insertTask();
		
		$this->assertContains($expectedMessageText, $mailMessage->body, 'Expected message not in email body');
	}
	
	protected function tearDown()
	{
		parent::tearDown();
		Yii::app()->setComponent("mail", null);
	}
	
}