<?php
/**
 * Tests for updating group notification
 * @author hvuong
 */
class TaskCommentNotificationReplyTest extends DbTestCase
{
	
	/*
	 * Test for notification email after updating group
	 */
	
	public function testTaskCommentNotificationReply()
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