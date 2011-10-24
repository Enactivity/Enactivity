<?php
/**
 * Tests for User::GetStatuses
 * @author ajsharma
 */
class UserGetStatusesTest extends DbTestCase
{
	/**
	 * Test get statuses returns all User statuses 
	 */
	public function testGetStatuses() {
		$statuses = array(self::STATUS_ACTIVE,
		self::STATUS_INACTIVE,
		self::STATUS_PENDING,
		self::STATUS_BANNED);
		
		$this->assertEquals($statuses, User::getStatuses());
	}
	
}