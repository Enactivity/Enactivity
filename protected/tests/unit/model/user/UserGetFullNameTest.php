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
}