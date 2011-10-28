<?php
/**
 * Tests for User::generateToken
 * @author ajsharma
 */
class UserGenerateTokenTest extends DbTestCase
{
	/**
	 * Test generated token is different on different calls
	 */
	public function testGenerateTokenIsDifferent() {
		$token = User::generateToken();
		$tokenAgain = User::generateToken();

		$this->assertNotEquals($token, $tokenAgain, 'Token generated is the same');
	}

}