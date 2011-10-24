<?php
/**
 * Tests for User::GetIsBanned
 * @author ajsharma
 */
class UserGetIsBannedTest extends DbTestCase
{
	/**
	 * Test if active user returns isBanned
	 */
	public function testActiveIsBanned() {
		$user = UserFactory::insert();
		$user->status = User::STATUS_ACTIVE;
		$this->assertFalse($user->isBanned, "Active status user doesn't return isBanned");
	}

	/**
	 * Test if banned user returns isBanned
	 */
	public function testBannedIsBanned() {
		$user = UserFactory::insert();
		$user->status = User::STATUS_BANNED;
		$this->assertTrue($user->isBanned, "Banned status user returns isBanned");
	}

	/**
	 * Test if inactive user returns isBanned
	 */
	public function testInactiveIsBanned() {
		$user = UserFactory::insert();
		$user->status = User::STATUS_INACTIVE;
		$this->assertFalse($user->isBanned, "Inactive status user returns isBanned");
	}

	/**
	 * Test if pending user returns isBanned
	 */
	public function testPendingIsBanned() {
		$user = UserFactory::insert();
		$user->status = User::STATUS_PENDING;
		$this->assertFalse($user->isBanned, "Pending status user returns isBanned");
	}


}