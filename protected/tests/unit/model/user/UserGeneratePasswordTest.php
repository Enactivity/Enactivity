<?php
/**
 * Tests for {@link User::generatePassword}
 * @author ajsharma
 */
class UserGeneratePasswordTest extends DbTestCase
{
	/**
	 * Test generated password is different on different calls
	 */
	public function testGeneratePasswordIsDifferent() {
		$password = User::generatePassword();
		$passwordAgain = User::generatePassword();

		$this->assertNotEquals($password, $passwordAgain, 'Password generated is the same');
	}

	/**
	 * Test generated password is alpha numeric
	 */
	public function testGeneratePasswordIsAlphaNumeric() {
		$password = User::generatePassword();

		$this->assertTrue(ctype_alnum($password), 'Password generated contains non-alphanumeric chars');
	}

}