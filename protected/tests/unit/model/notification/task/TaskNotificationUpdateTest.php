<?php
/**
 * Tests for updating group notification
 * @author hvuong
 */
class TaskNotificationUpdateTest extends DbTestCase
{
	
	/*
	 * Test for notification email after updating group
	 */
	
	public function testTaskNotificationUpdate()
	{
		$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
	}
	
	public function testGroupNotificationSubject()
	{
		$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
	}
	
	public function testGroupNotificationTo()
	{
		$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
	}

	protected function tearDown()
	{
		parent::tearDown();
		Yii::app()->setComponent("mail", null);
	}
	
}