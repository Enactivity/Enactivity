<?php
/**
 * Tests for updating group notification
 * @author hvuong
 */
class TaskCommentNotificationInsertTest extends DbTestCase
{
	
	/*
	 * Test for notification email after updating group
	 */
	
	public function testTaskCommentNotificationInsert()
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