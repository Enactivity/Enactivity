<?php
/**
 * Tests for User::isStatus
 * @author ajsharma
 */
class UserIsStatusTest extends DbTestCase
{
		/**
	 * Test if active user returns isBanned
	 */
	public function testActiveisStatus() {
		$user = UserFactory::insert();
		$user->status = User::STATUS_ACTIVE;
		$this->assertTrue($user->isStatus(User::STATUS_ACTIVE), "isStatus did not match status of user");
		$this->assertFalse($user->isStatus(User::STATUS_BANNED), "isStatus did not match status of user");
		$this->assertFalse($user->isStatus(User::STATUS_INACTIVE), "isStatus did not match status of user");
		$this->assertFalse($user->isStatus(User::STATUS_PENDING), "isStatus did not match status of user");
	}

	/**
	 * Test if banned user returns isBanned
	 */
	public function testBannedisStatus() {
		$user = UserFactory::insert();
		$user->status = User::STATUS_BANNED;
		$this->assertFalse($user->isStatus(User::STATUS_ACTIVE), "isStatus did not match status of user");
		$this->assertTrue($user->isStatus(User::STATUS_BANNED), "isStatus did not match status of user");
		$this->assertFalse($user->isStatus(User::STATUS_INACTIVE), "isStatus did not match status of user");
		$this->assertFalse($user->isStatus(User::STATUS_PENDING), "isStatus did not match status of user");
	}

	/**
	 * Test if inactive user returns isBanned
	 */
	public function testInactiveisStatus() {
		$user = UserFactory::insert();
		$user->status = User::STATUS_INACTIVE;
		$this->assertFalse($user->isStatus(User::STATUS_ACTIVE), "isStatus did not match status of user");
		$this->assertFalse($user->isStatus(User::STATUS_BANNED), "isStatus did not match status of user");
		$this->assertTrue($user->isStatus(User::STATUS_INACTIVE), "isStatus did not match status of user");
		$this->assertFalse($user->isStatus(User::STATUS_PENDING), "isStatus did not match status of user");
	}

	/**
	 * Test if pending user returns isBanned
	 */
	public function testPendingisStatus() {
		$user = UserFactory::insert();
		$user->status = User::STATUS_PENDING;
		$this->assertFalse($user->isStatus(User::STATUS_ACTIVE), "isStatus did not match status of user");
		$this->assertFalse($user->isStatus(User::STATUS_BANNED), "isStatus did not match status of user");
		$this->assertFalse($user->isStatus(User::STATUS_INACTIVE), "isStatus did not match status of user");
		$this->assertTrue($user->isStatus(User::STATUS_PENDING), "isStatus did not match status of user");
	}

}