<?php
/**
 * Tests for User::GetIsActive
 * @author ajsharma
 */
class UserGetIsActiveTest extends DbTestCase
{
	/**
	 * Test if active user returns isActive
	 */
	public function testActiveIsActive() {
		$user = UserFactory::insert();
		$user->status = User::STATUS_ACTIVE;
		$this->assertTrue($user->isActive, "Active status user doesn't return isActive");
	}

	/**
	 * Test if banned user returns isActive
	 */
	public function testBannedIsActive() {
		$user = UserFactory::insert();
		$user->status = User::STATUS_BANNED;
		$this->assertFalse($user->isActive, "Banned status user returns isActive");
	}

	/**
	 * Test if inactive user returns isActive
	 */
	public function testInactiveIsActive() {
		$user = UserFactory::insert();
		$user->status = User::STATUS_INACTIVE;
		$this->assertFalse($user->isActive, "Inactive status user returns isActive");
	}

	/**
	 * Test if pending user returns isActive
	 */
	public function testPendingIsActive() {
		$user = UserFactory::insert();
		$user->status = User::STATUS_PENDING;
		$this->assertFalse($user->isActive, "Pending status user returns isActive");
	}

}