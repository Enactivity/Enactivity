<?php
/**
 * Tests for {@link User::getFullName}
 * @author ajsharma
 */
class UserGetFullNameTest extends DbTestCase
{
	/**
	 * Test get full name
	 */
	public function testFullName() {
		$attributes = array(
			'firstName' => 'hello',
			'lastName' => 'world',
		);

		$user = UserFactory::insert($attributes);

		$this->assertEquals('hello world', $user->getFullName(), 'Get full name did not return full name');
	}

	/**
	 * Test get full name on user with no name is null
	 */
	public function testFullNameOnInvitedUser() {
		$attributes = array(
			'firstName' => 'hello',
			'lastName' => 'world',
		);

		$user = UserFactory::insertInvited($attributes);
		$this->assertNull($user->getFullName(), 'Get full name returned full name when user has no name');
	}
}