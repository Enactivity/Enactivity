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
		$statuses = array(User::STATUS_ACTIVE,
		User::STATUS_INACTIVE,
		User::STATUS_PENDING,
		User::STATUS_BANNED);
		
		$this->assertEquals($statuses, User::getStatuses());
	}
	
}