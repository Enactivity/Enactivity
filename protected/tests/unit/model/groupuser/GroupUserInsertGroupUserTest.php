<?php
/**
 * Tests for {@link membership::insertmembership}
 * @author ajsharma
 */
class membershipInsertmembershipTest extends DbTestCase
{
	/**
	 * Test that group insert works when group and user exist
	 */
	public function testGroupInsertValid() {
		$group = GroupFactory::insert();
		$user = UserFactory::insert();

		$membership = new membership();

		$this->assertTrue($membership->insertmembership($group->id, $user->id), "Group user was not inserted: " . $membership->errors);
		$this->assertEquals(membership::STATUS_ACTIVE, $membership->status, "membership status was not set to active on insert");
	}

	/**
	 * Test that group insert works throw exception
	 * @expectedException CDbException
	 */
	public function testGroupInsertValidTwiceException() {
		$group = GroupFactory::insert();
		$user = UserFactory::insert();

		$membership = new membership();
		$membership->insertmembership($group->id, $user->id);
		$membership->insertmembership($group->id, $user->id); // call it twice
	}

	/**
	 * Test that group insert fails when group is null
	 */
	public function testGroupInsertGroupNullIsInvalid() {
		$user = UserFactory::insert();

		$membership = new membership();

		$this->assertFalse($membership->insertmembership(null, $user->id), "Group user was inserted: " . $membership->errors);
		$this->assertNotNull($membership->getError('groupId'), "No error set on null group");
	}

	/**
	 * Test that group insert fails when user is null
	 */
	public function testGroupInsertUserNullIsInvalid() {
		$group = GroupFactory::insert();

		$membership = new membership();

		$this->assertFalse($membership->insertmembership($group->id, null), "Group user was inserted: " . $membership->errors);
		$this->assertNotNull($membership->getError('userId'), "No error set on null user");
	}

	/**
	 * Test that group insert fails when group is null
	 */
	public function testGroupInsertGroupAndUserNullIsInvalid() {
		$membership = new membership();

		$this->assertFalse($membership->insertmembership(null, null), "Group user was inserted: " . $membership->errors);
		$this->assertNotNull($membership->getError('groupId'), "No error set on null group");
		$this->assertNotNull($membership->getError('userId'), "No error set on null user");
	}
}