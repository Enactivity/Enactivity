<?php
/**
 * Tests for updating group notification
 * @author hvuong
 */
class TaskUserNotificationCompleteTest extends DbTestCase
{
	
	/*
	 * Test for notification email after updating group
	 */
	
	public function testTaskUserNotificationComplete()
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