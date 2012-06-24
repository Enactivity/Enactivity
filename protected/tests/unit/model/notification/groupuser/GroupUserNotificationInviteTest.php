<?php
/**
 * Tests for updating group notification
 * @author hvuong
 */
class GroupUserNotificationInviteTest extends DbTestCase
{
	
	/*
	 * Test for notification email after updating group
	 */
	
	public function testGroupNotificationSubject()
	{
	}
	
	public function testGroupNotificationTo()
	{
	}
	
	public function testGroupNotificationBody()
	{
	}

	protected function tearDown()
	{
		parent::tearDown();
		Yii::app()->setComponent("mail", null);
	}
	
}