<?php
/**
 * Tests for updating group notification
 * @author hvuong
 */
class TaskUserNotificationInsertTest extends DbTestCase
{
	
	/*
	 * Test for notification email after updating group
	 */
	
	public function testTaskUserNotificationInsert()
	{
	}
	
	protected function tearDown()
	{
		parent::tearDown();
		Yii::app()->setComponent("mail", null);
	}
}