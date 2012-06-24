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
	}
	
	public function testGroupNotificationSubject()
	{
	}
	
	public function testGroupNotificationTo()
	{
	}

	protected function tearDown()
	{
		parent::tearDown();
		Yii::app()->setComponent("mail", null);
	}
	
}