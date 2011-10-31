<?php
/**
 * Tests for User::isPassword
 * @author ajsharma
 */
class UserIsPasswordTest extends DbTestCase
{
	/**
	 * Test isPassword works when password match
	 */
	public function testIsPasswordValid() {
		$password = StringUtils::createRandomAlphaString();
		$user = UserFactory::insert(array(
			'password' => $password,
		));
		
		$this->assertTrue($user->isPassword($password), "Password does not match saved password");
		$this->assertFalse($user->isPassword(StringUtils::createRandomAlphaString()), "Password matches random string");
	}
	
	/**
	 * Verify that isPassword breaks if the user's token changes.
	 */
	public function testIsPasswordBreaksOnTokenChange() {
		$password = StringUtils::createRandomAlphaString();
		$user = UserFactory::insert(array(
				'password' => $password,
		));
		
		$user->token = StringUtils::createRandomString();
		$this->assertFalse($user->isPassword($password), "Password matches password after token changes");
	}
	
}