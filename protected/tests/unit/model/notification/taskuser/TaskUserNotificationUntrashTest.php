<?php
/**
 * Tests for updating group notification
 * @author hvuong
 */
class TaskUserNotificationUntrashTest extends DbTestCase
{
	
	/*
	 * Test for notification email after updating group
	 */
	
	public function testTaskUserNotificationUntrash()
	{
	}
	
	protected function tearDown()
	{
		parent::tearDown();
		Yii::app()->setComponent("mail", null);
	}
}