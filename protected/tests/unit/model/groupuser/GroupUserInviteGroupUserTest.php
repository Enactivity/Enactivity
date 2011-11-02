<?php
/**
 * Tests for {@link GroupUser::inviteGroupUser}
 * @author ajsharma
 */
class GroupUserInviteGroupUserTest extends DbTestCase
{
	/**
	 * Test that group invite works when group and user exist
	 */
	public function testGroupInviteValid() {
		$group = GroupFactory::insert();
		$user = UserFactory::insert();

		$groupUser = new GroupUser();

		$this->assertTrue($groupUser->inviteGroupUser($group->id, $user->id), "Group user was not invited: " . $groupUser->errors);
		$this->assertEquals(GroupUser::STATUS_PENDING, $groupUser->status, "GroupUser status was not set to active on invite");
	}

	/**
	 * Test that group invite works multiple times
	 */
	public function testGroupInviteValidTwiceSucceeds() {
		$group = GroupFactory::insert();
		$user = UserFactory::insert();

		$groupUser = new GroupUser();
		$groupUser->inviteGroupUser($group->id, $user->id);

		$this->assertTrue($groupUser->inviteGroupUser($group->id, $user->id), "Group user was not invited twice: " . $groupUser->errors);
	}

	/**
	 * Test that group invite works multiple times
	 */
	public function testGroupInviteValidTwiceIndependantlySucceeds() {
		$this->markTestIncomplete("Skipped while refactoring tests");
		
		$group = GroupFactory::insert();
		$user = UserFactory::insert();

		$groupUser = new GroupUser();
		$groupUser->inviteGroupUser($group->id, $user->id);

		$groupUserSecondChance = new GroupUser();
		$this->assertTrue($groupUserSecondChance->inviteGroupUser($group->id, $user->id), "Group user was not invited twice: " . $groupUser->errors);
	}

	/**
	 * Test that group invite fails when group is null
	 */
	public function testGroupInviteGroupNullIsInvalid() {
		$user = UserFactory::insert();

		$groupUser = new GroupUser();

		$this->assertFalse($groupUser->inviteGroupUser(null, $user->id), "Group user was invited: " . $groupUser->errors);
		$this->assertNotNull($groupUser->getError('groupId'), "No error set on null group");
	}

	/**
	 * Test that group invite fails when user is null
	 */
	public function testGroupInviteUserNullIsInvalid() {
		$group = GroupFactory::insert();

		$groupUser = new GroupUser();

		$this->assertFalse($groupUser->inviteGroupUser($group->id, null), "Group user was invited: " . $groupUser->errors);
		$this->assertNotNull($groupUser->getError('userId'), "No error set on null user");
	}

	/**
	 * Test that group invite fails when group is null
	 */
	public function testGroupInviteGroupAndUserNullIsInvalid() {
		$groupUser = new GroupUser();

		$this->assertFalse($groupUser->inviteGroupUser(null, null), "Group user was invited: " . $groupUser->errors);
		$this->assertNotNull($groupUser->getError('groupId'), "No error set on null group");
		$this->assertNotNull($groupUser->getError('userId'), "No error set on null user");
	}
}