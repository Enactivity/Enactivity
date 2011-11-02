<?php
/**
 * Tests for {@link GroupUser::insertGroupUser}
 * @author ajsharma
 */
class GroupUserInsertGroupUserTest extends DbTestCase
{
	/**
	 * Test that group insert works when group and user exist
	 */
	public function testGroupInsertValid() {
		$group = GroupFactory::insert();
		$user = UserFactory::insert();

		$groupUser = new GroupUser();

		$this->assertTrue($groupUser->insertGroupUser($group->id, $user->id), "Group user was not inserted: " . $groupUser->errors);
		$this->assertEquals(GroupUser::STATUS_ACTIVE, $groupUser->status, "GroupUser status was not set to active on insert");
	}

	/**
	 * Test that group insert works throw exception
	 * @expectedException CDbException
	 */
	public function testGroupInsertValidTwiceException() {
		$group = GroupFactory::insert();
		$user = UserFactory::insert();

		$groupUser = new GroupUser();
		$groupUser->insertGroupUser($group->id, $user->id);
		$groupUser->insertGroupUser($group->id, $user->id); // call it twice
	}

	/**
	 * Test that group insert fails when group is null
	 */
	public function testGroupInsertGroupNullIsInvalid() {
		$user = UserFactory::insert();

		$groupUser = new GroupUser();

		$this->assertFalse($groupUser->insertGroupUser(null, $user->id), "Group user was inserted: " . $groupUser->errors);
		$this->assertNotNull($groupUser->getError('groupId'), "No error set on null group");
	}

	/**
	 * Test that group insert fails when user is null
	 */
	public function testGroupInsertUserNullIsInvalid() {
		$group = GroupFactory::insert();

		$groupUser = new GroupUser();

		$this->assertFalse($groupUser->insertGroupUser($group->id, null), "Group user was inserted: " . $groupUser->errors);
		$this->assertNotNull($groupUser->getError('userId'), "No error set on null user");
	}

	/**
	 * Test that group insert fails when group is null
	 */
	public function testGroupInsertGroupAndUserNullIsInvalid() {
		$groupUser = new GroupUser();

		$this->assertFalse($groupUser->insertGroupUser(null, null), "Group user was inserted: " . $groupUser->errors);
		$this->assertNotNull($groupUser->getError('groupId'), "No error set on null group");
		$this->assertNotNull($groupUser->getError('userId'), "No error set on null user");
	}
}