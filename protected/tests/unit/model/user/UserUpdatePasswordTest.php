<?php
/**
 * Tests for {@link User::UpdatePassword}
 * @author ajsharma
 */
class UserUpdatePasswordTest extends DbTestCase
{
	var $attributes = array();

	public function setUp() {
		parent::setUp();

		$password = StringUtils::createRandomAlphaString();

		$this->attributes = array(
			'id' => StringUtils::createRandomAlphaString(),
			'email' => StringUtils::createRandomEmail(),
			'token' => StringUtils::createRandomAlphaString(),
			'password' => $password,
			'confirmPassword' => $password,
			'firstName' => StringUtils::createRandomAlphaString(),
			'lastName' => StringUtils::createRandomAlphaString(),
			'timeZone' => array_rand(PDateTime::timeZoneArray()),
			'status' => StringUtils::createRandomAlphaString(),
			'isAdmin' => StringUtils::createRandomAlphaString(),
			'created' => StringUtils::createRandomAlphaString(),
			'modified' => StringUtils::createRandomAlphaString(),
			'lastLogin' => StringUtils::createRandomAlphaString(),
		);
	}

	/**
	 * Test that user is updated on valid attributes
	 */
	public function testUpdatePasswordValid() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));
	}

	/**
	 * Test that user Id is not set by system on UpdatePassword
	 */
	public function testUpdatePasswordIgnoresId() {

		$user = UserFactory::insert();
		$oldId = $user->id;

		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->id, 'Id was not set on UpdatePassword');
		$this->assertNotEquals($this->attributes['id'], $user->id, 'Id was set by user on UpdatePassword');
		$this->assertEquals($oldId, $user->id, "Updating user changed Id");
	}

	/**
	 * Test that user update password ignores email
	 */
	public function testUpdatePasswordIgnoresEmail() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['email'], $user->email, 'Email was set by user on UpdatePassword');
	}

	/**
	 * Test that user update password ignores null email
	 */
	public function testUpdatePasswordIgnoresNullEmail() {

		$user = UserFactory::insert();
		$this->attributes['email'] = null;

		$this->assertTrue($user->updatePassword($this->attributes), "User with null email was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['email'], $user->email, 'Email was set by user on UpdatePassword');
	}

	/**
	 * Test that user update password ignores invalid email format
	 */
	public function testUpdatePasswordIgnoresInvalidEmailFormat() {

		$user = UserFactory::insert();
		$this->attributes['email'] = StringUtils::createRandomAlphaString();

		$this->assertTrue($user->updatePassword($this->attributes), "User with invalid email was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['email'], $user->email, 'Email was set by user on UpdatePassword');
	}

	/**
	 * Test that user update password ignores email format
	 */
	public function testUpdatePasswordIgnoresLongEmailFormat() {

		$user = UserFactory::insert();
		$this->attributes['email'] = StringUtils::createRandomAlphaString(55) . '@alpha.poncla.com';

		$this->assertTrue($user->updatePassword($this->attributes), "User with invalid email was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['email'], $user->email, 'Email was set by user on UpdatePassword');
	}

	/**
	 * Test that user update password ignores email format
	 */
	public function testUpdatePasswordIgnoresTrimEmail() {

		$user = UserFactory::insert();
		$this->attributes['email'] = " " . $this->attributes['email'] . " ";

		$this->assertTrue($user->updatePassword($this->attributes), "User with untrimmed email did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['email'], $user->email, 'Email set by user on UpdatePassword');
	}

	/**
	 * Test that user token is ignored when updating password
	 */
	public function testUpdatePasswordIgnoresToken() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['token'], $user->token, 'Token was set by user on UpdatePassword');
	}

	/**
	 * Test that user password is set on UpdatePassword
	 */
	public function testUpdatePasswordValidIgnoresPassword() {

		$user = UserFactory::insert();
		$oldPassword = $user->password;

		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($oldPassword, $user->password, 'password was not set by user on UpdatePassword');
		$this->assertNotEquals($this->attributes['password'], $user->password, 'password was no encrypted on update password');
	}

	/**
	 * Test that user password is not updated with a null password
	 */
	public function testUpdatePasswordNullPassword() {

		$this->attributes['password'] = null;

		$user = UserFactory::insert();

		$this->assertFalse($user->updatePassword($this->attributes), "User updated with null password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('password'), 'null password did not set password error');
	}

	/**
	 * Test that user is not updated with too short password
	 */
	public function testUpdatePasswordShortPassword() {

		$this->attributes['password'] = StringUtils::createRandomAlphaString(3);

		$user = UserFactory::insert();

		$this->assertFalse($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('password'), 'short password did not set password error');
	}

	/**
	 * Test that user is not updated with long password
	 */
	public function testUpdatePasswordLongPassword() {

		$this->attributes['password'] = StringUtils::createRandomAlphaString(45);

		$user = UserFactory::insert();

		$this->assertFalse($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('password'), 'long password did not set password error');
	}

	/**
	 * Test that user confirmPassword is set by user on UpdatePassword
	 */
	public function testUpdatePasswordValidConfirmPassword() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->confirmPassword, 'confirmPassword was set on UpdatePassword');
		$this->assertEquals($this->attributes['confirmPassword'], $user->confirmPassword, 'confirmPassword was not set by user on UpdatePassword');
	}

	/**
	 * Test that user first name is ignored on UpdatePassword
	 */
	public function testUpdatePasswordIgnoresFirstName() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['firstName'], $user->firstName, 'First name was set by user on UpdatePassword');
	}

	/**
	 * Test that user first name is ignored on update password
	 */
	public function testUpdatePasswordIgnoresShortFirstName() {

		$user = UserFactory::insert();
		$this->attributes['firstName'] = StringUtils::createRandomAlphaString(1);

		$this->assertTrue($user->updatePassword($this->attributes), "short firstName blocked update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['firstName'], $user->firstName, 'First name was set by user on UpdatePassword');
	}

	/**
	 * Test that user long first name is ignored on update password
	 */
	public function testUpdatePasswordIgnoresLongFirstName() {

		$user = UserFactory::insert();
		$this->attributes['firstName'] = StringUtils::createRandomAlphaString(55);

		$this->assertTrue($user->updatePassword($this->attributes), "long first name blocked update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['firstName'], $user->firstName, 'First name was set by user on UpdatePassword');
	}

	/**
	 * Test that user alpha numeric first name is ignored on update password
	 */
	public function testUpdatePasswordIgnoresAlphaNumericFirstName() {

		$user = UserFactory::insert();
		$this->attributes['firstName'] .= '0';

		$this->assertTrue($user->updatePassword($this->attributes), "numeric first name blocked update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['firstName'], $user->firstName, 'First name was set by user on UpdatePassword');
	}

	/**
	 * Test that user untrimmed firstname is ignored on update password
	 */
	public function testUpdatePasswordIgnoresTrimFirstName() {

		$user = UserFactory::insert();
		$this->attributes['firstName'] = " " . $this->attributes['firstName'] . " ";

		$this->assertTrue($user->updatePassword($this->attributes), "untrimmed first name blocked update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['firstName'], $user->firstName, 'First name was set by user on UpdatePassword');
	}

	/**
	 * Test that user last name is ignored on UpdatePassword
	 */
	public function testUpdatePasswordIgnoresLastName() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['lastName'], $user->lastName, 'Last name was set by user on UpdatePassword');
	}

	/**
	 * Test that user last name is ignored on update password
	 */
	public function testUpdatePasswordIgnoresShortLastName() {

		$user = UserFactory::insert();
		$this->attributes['lastName'] = StringUtils::createRandomAlphaString(1);

		$this->assertTrue($user->updatePassword($this->attributes), "short lastName blocked update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['lastName'], $user->lastName, 'Last name was set by user on UpdatePassword');
	}

	/**
	 * Test that user long last name is ignored on update password
	 */
	public function testUpdatePasswordIgnoresLongLastName() {

		$user = UserFactory::insert();
		$this->attributes['lastName'] = StringUtils::createRandomAlphaString(55);

		$this->assertTrue($user->updatePassword($this->attributes), "long last name blocked update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['lastName'], $user->lastName, 'Last name was set by user on UpdatePassword');
	}

	/**
	 * Test that user alpha numeric last name is ignored on update password
	 */
	public function testUpdatePasswordIgnoresAlphaNumericLastName() {

		$user = UserFactory::insert();
		$this->attributes['lastName'] .= '0';

		$this->assertTrue($user->updatePassword($this->attributes), "numeric last name blocked update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['lastName'], $user->lastName, 'Last name was set by user on UpdatePassword');
	}

	/**
	 * Test that user untrimmed lastname is ignored on update password
	 */
	public function testUpdatePasswordIgnoresTrimLastName() {

		$user = UserFactory::insert();
		$this->attributes['lastName'] = " " . $this->attributes['lastName'] . " ";

		$this->assertTrue($user->updatePassword($this->attributes), "untrimmed last name blocked update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['lastName'], $user->lastName, 'Last name was set by user on UpdatePassword');
	}

	/**
	 * Test that user timezone is ignored UpdatePassword
	 */
	public function testUpdatePasswordIgnoresTimeZone() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['timeZone'], $user->timeZone, 'Time zone was set by user on UpdatePassword');
	}

	/**
	 * Test that user timezone is a timezone
	 */
	public function testUpdatePasswordIgnoresInvalidTimeZone() {

		$user = UserFactory::insert();
		$this->attributes['timeZone'] .= StringUtils::createRandomAlphaString();

		$this->assertTrue($user->updatePassword($this->attributes), "User with invalid timeZone value did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['timeZone'], $user->timeZone, 'Time zone was set by user on UpdatePassword');
	}

	/**
	 * Test that user timezone only allows supported time zones
	 */
	public function testUpdatePasswordIgnoresUnsupportedTimeZone() {

		$user = UserFactory::insert();
		$this->attributes['timeZone'] .= 'Antarctica/South_Pole';

		$this->assertTrue($user->updatePassword($this->attributes), "User with antartic timeZone value did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['timeZone'], $user->timeZone, 'Time zone was set by user on UpdatePassword');
	}

	/**
	 * Test that user status is set to active by system on UpdatePassword
	 */
	public function testUpdatePasswordIgnoresStatus() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['status'], $user->status, 'status set by user on UpdatePassword');
		$this->assertEquals(User::STATUS_ACTIVE, $user->status, "User status was changed on UpdatePassword");
	}

	/**
	 * Test that user isAdmin is set by system to false on UpdatePassword
	 */
	public function testUpdatePasswordIgnoresIsAdmin() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['isAdmin'], $user->isAdmin, 'isAdmin set by user on UpdatePassword');

		$this->assertEquals(0, $user->isAdmin, "User was set to admin on UpdatePassword");
	}

	/**
	 * Test that user created is set by system on UpdatePassword
	 */
	public function testUpdatePasswordIgnoresCreated() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['created'], $user->created, 'created set by user on UpdatePassword');
	}

	/**
	 * Test that user modified is set by system on UpdatePassword
	 */
	public function testUpdatePasswordIgnoresModified() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['modified'], $user->modified, 'modified set by user on UpdatePassword');
	}

	/**
	 * Test that user login is ignored on UpdatePassword
	 */
	public function testUpdatePasswordIgnoresLastLogin() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updatePassword($this->attributes), "User did not update password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotEquals($this->attributes['lastLogin'], $user->lastLogin, 'lastLogin set by user on UpdatePassword');
	}

	/**
	 * Test that user is not saved on null attributes
	 */
	public function testUpdatePasswordNullAttributes() {

		$user = UserFactory::insert();
		$this->assertFalse($user->updatePassword(null), "UpdatePassword(null) returns true");
	}

	/**
	 * Test that user scenario is still set on null attributes
	 */
	public function testUpdatePasswordNullAttributesSetsScenario() {

		$user = UserFactory::insert();
		$user->updatePassword(null);
		$this->assertEquals(User::SCENARIO_UPDATE_PASSWORD, $user->scenario);
	}

	/**
	 * Test that user scenario is still set on invalid attributes
	 */
	public function testUpdatePasswordInvalidAttributesSetsScenario() {

		$this->attributes['email'] = StringUtils::createRandomAlphaString();

		$user = UserFactory::insert();
		$user->updatePassword($this->attributes);
		$this->assertEquals(User::SCENARIO_UPDATE_PASSWORD, $user->scenario);
	}

	/**
	 * Test that updating a user that doesn't exist throws an exception
	 * @expectedException CDbException
	 */
	public function testUpdatePasswordOnNonExistingUser() {
		$user = new User();
		$user->updatePassword();
	}
}