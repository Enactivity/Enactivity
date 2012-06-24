<?php
/**
 * Tests for updating group notification
 * @author hvuong
 */
class TaskUserNotificationTrashTest extends DbTestCase
{
	
	/*
	 * Test for notification email after updating group
	 */
	
	public function testTaskUserNotificationTrash()
	{
	}
	
	protected function tearDown()
	{
		parent::tearDown();
		Yii::app()->setComponent("mail", null);
	}
}