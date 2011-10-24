<?php
/**
 * Tests for {@link User::encrypt}
 * @author ajsharma
 */
class UserEncryptTest extends DbTestCase
{
	/**
	 * Test that string is changed
	 */
	public function testEncryptValid() {
		$testString = 'testString';
		$token = StringUtils::uniqueString();

		$encrypted = User::encrypt($testString, $token);

		$this->assertNotNull($encrypted);
		$this->assertNotEquals($testString, $encrypted, "String was not encrypted");
	}

	/**
	 * Test that two encryption calls result in same value
	 */
	public function testEncryptSameStringAndToken() {
		$testString = 'testString';
		$token = StringUtils::uniqueString();
		$differentToken = StringUtils::uniqueString();

		$encrypted = User::encrypt($testString, $token);
		$encryptedSame = User::encrypt($testString, $token);

		$this->assertNotNull($encrypted);
		$this->assertNotNull($encryptedSame);

		$this->assertEquals($encrypted, $encryptedSame, "Encrypt call resulted in two different strings");
	}

	/**
	 * Test that different strings with the same token result in different results
	 */
	public function testEncryptDifferentStringsSameToken() {
		$testString = 'testString';
		$differentTestString = 'teststring';
		$token = StringUtils::uniqueString();

		$encrypted = User::encrypt($testString, $token);
		$encryptedDiffString = User::encrypt($differentTestString, $token);

		$this->assertNotNull($encrypted);
		$this->assertNotNull($encryptedDiffString);

		$this->assertNotEquals($encrypted, $encryptedDiffString, "Encrypting two strings with same token resulted in same string");
	}

	/**
	 * Test that encrypt with different tokens results in different results
	 */
	public function testEncryptDifferentToken() {
		$testString = 'testString';
		$token = StringUtils::uniqueString();
		$differentToken = StringUtils::uniqueString();

		$encrypted = User::encrypt($testString, $token);
		$encryptedDiffToken = User::encrypt($testString, $differentToken);

		$this->assertNotNull($encrypted);
		$this->assertNotNull($encryptedDiffToken);

		$this->assertNotEquals($encrypted, $encryptedDiffToken, "Encrypting string with different token resulted in same string");
	}

	/**
	 * Test that different strings and tokens result in different results
	 */
	public function testEncryptDifferentStringAndToken() {
		$testString = 'testString';
		$differentTestString = 'teststring';
		$token = StringUtils::uniqueString();
		$differentToken = StringUtils::uniqueString();

		$encrypted = User::encrypt($testString, $token);
		$encryptedDiffBoth = User::encrypt($differentTestString, $differentToken);

		$this->assertNotNull($encrypted);
		$this->assertNotNull($encryptedDiffBoth);
		$this->assertNotEquals($encrypted, $encryptedDiffBoth, "Encrypting two strings with different tokens resulted in same string");
	}

	/**
	 * Verify empty string throws exception
	 */
	public function testEncryptEmptyString() {
		try {
			User::encrypt('', StringUtils::uniqueString());
		}
		catch (Exception $e) {
			return;
		}

		$this->fail('No exception throw when encrypting empty string');
	}

	/**
	 * Verify empty string throws exception
	 */
	public function testEncryptNullString() {
		try {
			User::encrypt(null, StringUtils::uniqueString());
		}
		catch (Exception $e) {
			return;
		}

		$this->fail('No exception throw when encrypting null string');
	}

	/**
	 * Verify null token results in exception
	 */
	public function testEncryptEmptyToken() {
		try {
			User::encrypt(StringUtils::uniqueString(), '');
		}
		catch (Exception $e) {
			return;
		}

		$this->fail('No exception throw when encrypting with empty token');
	}

	/**
	 * Verify null token results in exception
	 */
	public function testEncryptNullToken() {
		try {
			User::encrypt(StringUtils::uniqueString(), null);
		}
		catch (Exception $e) {
			return;
		}

		$this->fail('No exception throw when encrypting with null token');
	}

	/**
	 * Verify empty params results in exception
	 */
	public function testEncryptEmptyParams() {
		try {
			User::encrypt('', '');
		}
		catch (Exception $e) {
			return;
		}

		$this->fail('No exception throw when encrypting with empty string and token');
	}

	/**
	 * Verify null params results in exception
	 */
	public function testEncryptNullParams() {
		try {
			User::encrypt(null, null);
		}
		catch (Exception $e) {
			return;
		}

		$this->fail('No exception throw when encrypting with null string and token');
	}

}