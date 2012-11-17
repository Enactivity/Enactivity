<?php
/**
 * Tests for updating membership notification
 * @author hvuong
 */
class membershipNotificationJoinTest extends DbTestCase
{
	
	/*
	 * Test for notification email after updating group
	 */
	
	public function testGroupNotificationJoin()
	{
		//test for join
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