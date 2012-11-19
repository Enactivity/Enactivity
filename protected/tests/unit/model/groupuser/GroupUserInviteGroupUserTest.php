<?php
/**
 * Tests for {@link membership::inviteToGroup}
 * @author ajsharma
 */
class membershipInvitemembershipTest extends DbTestCase
{
	/**
	 * Test that group invite works when group and user exist
	 */
	public function testGroupInviteValid() {
		$group = GroupFactory::insert();
		$user = UserFactory::insert();

		$membership = new membership();

		$this->assertTrue($membership->inviteToGroup($group->id, $user->id), "Group user was not invited: " . $membership->errors);
		$this->assertEquals(membership::STATUS_PENDING, $membership->status, "membership status was not set to active on invite");
	}

	/**
	 * Test that group invite works multiple times
	 */
	public function testGroupInviteValidTwiceSucceeds() {
		$group = GroupFactory::insert();
		$user = UserFactory::insert();

		$membership = new membership();
		$membership->inviteToGroup($group->id, $user->id);

		$this->assertTrue($membership->inviteToGroup($group->id, $user->id), "Group user was not invited twice: " . $membership->errors);
	}

	/**
	 * Test that group invite works multiple times
	 */
	public function testGroupInviteValidTwiceIndependantlySucceeds() {
		$this->markTestIncomplete("Skipped while refactoring tests");
		
		$group = GroupFactory::insert();
		$user = UserFactory::insert();

		$membership = new membership();
		$membership->inviteToGroup($group->id, $user->id);

		$membershipSecondChance = new membership();
		$this->assertTrue($membershipSecondChance->inviteToGroup($group->id, $user->id), "Group user was not invited twice: " . $membership->errors);
	}

	/**
	 * Test that group invite fails when group is null
	 */
	public function testGroupInviteGroupNullIsInvalid() {
		$user = UserFactory::insert();

		$membership = new membership();

		$this->assertFalse($membership->inviteToGroup(null, $user->id), "Group user was invited: " . $membership->errors);
		$this->assertNotNull($membership->getError('groupId'), "No error set on null group");
	}

	/**
	 * Test that group invite fails when user is null
	 */
	public function testGroupInviteUserNullIsInvalid() {
		$group = GroupFactory::insert();

		$membership = new membership();

		$this->assertFalse($membership->inviteToGroup($group->id, null), "Group user was invited: " . $membership->errors);
		$this->assertNotNull($membership->getError('userId'), "No error set on null user");
	}

	/**
	 * Test that group invite fails when group is null
	 */
	public function testGroupInviteGroupAndUserNullIsInvalid() {
		$membership = new membership();

		$this->assertFalse($membership->inviteToGroup(null, null), "Group user was invited: " . $membership->errors);
		$this->assertNotNull($membership->getError('groupId'), "No error set on null group");
		$this->assertNotNull($membership->getError('userId'), "No error set on null user");
	}
}