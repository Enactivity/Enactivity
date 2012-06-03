<?php
/**
 * Tests for User::updateUser
 * @author ajsharma
 */
class UserUpdateUserTest extends DbTestCase
{
	var $attributes = array();

	public function setUp() {
		parent::setUp();

		$this->attributes = array(
			'id' => StringUtils::createRandomAlphaString(),
			'email' => StringUtils::createRandomEmail(),
			'token' => StringUtils::createRandomAlphaString(),
			'password' => StringUtils::createRandomAlphaString(),
			'confirmPassword' => StringUtils::createRandomAlphaString(),
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
	public function testUpdateUserValid() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));
	}

	/**
	 * Test that user Id is set by system on Update
	 */
	public function testUpdateUserValidSystemSetsId() {

		$user = UserFactory::insert();
		$oldId = $user->id;
		
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->id, 'Id was not set on updateUser');
		$this->assertNotEquals($this->attributes['id'], $user->id, 'Id was set by user on updateUser');
		$this->assertEquals($oldId, $user->id, "Updating user changed Id");
	}

	/**
	 * Test that user email is set by user on Update
	 */
	public function testUpdateUserValidUserSetsEmail() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->email, 'email was not set on updateUser');
		$this->assertEquals($this->attributes['email'], $user->email, 'Email was not set by user on updateUser');
	}

	/**
	 * Test that user is not updated with null email
	 */
	public function testUpdateUserNullEmail() {

		$user = UserFactory::insert();
		$this->attributes['email'] = null;

		$this->assertFalse($user->updateUser($this->attributes), "User with null email was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('email'), 'null email did not cause error on update');
	}

	/**
	 * Test that user is not updated with invalid email format
	 */
	public function testUpdateUserInvalidEmailFormat() {

		$user = UserFactory::insert();
		$this->attributes['email'] = StringUtils::createRandomAlphaString();

		$this->assertFalse($user->updateUser($this->attributes), "User with invalid email was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('email'), 'null email did not cause error on update');
	}

	/**
	 * Test that user is not updated with long email
	 */
	public function testUpdateUserLongEmailFormat() {

		$user = UserFactory::insert();
		$this->attributes['email'] = StringUtils::createRandomAlphaString(55) . '@alpha.poncla.com';

		$this->assertFalse($user->updateUser($this->attributes), "User with invalid email was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('email'), 'null email did not cause error on update');
	}

	/**
	 * Test that user email is trimmed
	 */
	public function testUpdateUserTrimEmail() {

		$user = UserFactory::insert();
		$this->attributes['email'] = " " . $this->attributes['email'] . " ";

		$this->assertTrue($user->updateUser($this->attributes), "User with untrimmed email was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertEquals(trim($this->attributes['email']), $user->email, "User email was not trimmed on update");
	}

	/**
	 * Test that user token is set by system on Update
	 */
	public function testUpdateUserValidSystemSetsToken() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->token, 'token was not set on updateUser');
		$this->assertNotEquals($this->attributes['token'], $user->token, 'Token was set by user on updateUser');
	}

	/**
	 * Test that user password is ignored on Update
	 */
	public function testUpdateUserValidIgnoresPassword() {

		$user = UserFactory::insert();
		$oldPassword = $user->password;
		
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertEquals($oldPassword, $user->password, 'password was set by user on updateUser');
	}

	/**
	 * Test that user password is ignored with null password
	 */
	public function testUpdateUserValidIgnoresNullPassword() {

		$this->attributes['password'] = null;

		$user = UserFactory::insert();
		$oldPassword = $user->password;
		
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertEquals($oldPassword, $user->password, 'password was set by user on updateUser');
	}

	/**
	 * Test that user is not updated with too short password
	 */
	public function testUpdateUserShortPassword() {

		$this->attributes['password'] = StringUtils::createRandomAlphaString(3);
		
		$user = UserFactory::insert();
		$oldPassword = $user->password;
		
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));
		
		$this->assertEquals($oldPassword, $user->password, 'password was set by user on updateUser');
	}

	/**
	 * Test that user is updated regardless of long password
	 */
	public function testUpdateUserLongPassword() {

		$this->attributes['password'] = StringUtils::createRandomAlphaString(45);
		
		$user = UserFactory::insert();
		$oldPassword = $user->password;
		
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));
		
		$this->assertEquals($oldPassword, $user->password, 'password was set by user on updateUser');	}

	/**
	 * Test that user confirmPassword is not set by user on Update
	 */
	public function testUpdateUserValidIgnoresConfirmPassword() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNull($user->confirmPassword, 'confirmPassword was set on updateUser');
		$this->assertNotEquals($this->attributes['confirmPassword'], $user->confirmPassword, 'confirmPassword set by user on updateUser');
	}

	/**
	 * Test that user first name is set by user on Update
	 */
	public function testUpdateUserValidUserSetsFirstName() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->firstName, 'firstName was not set on updateUser');
		$this->assertEquals($this->attributes['firstName'], $user->firstName, 'First name was not set by user on updateUser');
	}

	/**
	 * Test that user is not updated with too short first name
	 */
	public function testUpdateUserShortFirstName() {

		$user = UserFactory::insert();
		$this->attributes['firstName'] = StringUtils::createRandomAlphaString(1);

		$this->assertFalse($user->updateUser($this->attributes), "User with short firstName was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('firstName'), 'short firstName did not cause error on update');
	}

	/**
	 * Test that user is not updated with too long first name
	 */
	public function testUpdateUserLongFirstName() {

		$user = UserFactory::insert();
		$this->attributes['firstName'] = StringUtils::createRandomAlphaString(55);

		$this->assertFalse($user->updateUser($this->attributes), "User with long firstName was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('firstName'), 'long firstName did not cause error on update');
	}

	/**
	 * Test that user is not updated with a alpha numeric first name
	 */
	public function testUpdateUserAlphaNumericFirstName() {

		$user = UserFactory::insert();
		$this->attributes['firstName'] .= '0';

		$this->assertFalse($user->updateUser($this->attributes), "User with non-alphabetic firstName was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('firstName'), 'non-alphabetic firstName did not cause error on update');
	}

	/**
	 * Test that user firstname is trimmed
	 */
	public function testUpdateUserTrimFirstName() {

		$user = UserFactory::insert();
		$this->attributes['firstName'] = " " . $this->attributes['firstName'] . " ";

		$this->assertTrue($user->updateUser($this->attributes), "User with untrimmed firstName was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertEquals(trim($this->attributes['firstName']), $user->firstName, "User firstName was not trimmed on update");
	}

	/**
	 * Test that user last name is set by user on Update
	 */
	public function testUpdateUserValidUserSetsLastName() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->lastName, 'lastName was not set on updateUser');
		$this->assertEquals($this->attributes['lastName'], $user->lastName, 'Last name was not set by user on updateUser');
	}

	/**
	 * Test that user is not updated with too short last name
	 */
	public function testUpdateUserShortLastName() {

		$user = UserFactory::insert();
		$this->attributes['lastName'] = StringUtils::createRandomAlphaString(1);

		$this->assertFalse($user->updateUser($this->attributes), "User with short lastName was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('lastName'), 'short lastName did not cause error on update');
	}

	/**
	 * Test that user is not updated with too long last name
	 */
	public function testUpdateUserLongLastName() {

		$user = UserFactory::insert();
		$this->attributes['lastName'] = StringUtils::createRandomAlphaString(55);

		$this->assertFalse($user->updateUser($this->attributes), "User with long lastName was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('lastName'), 'long lastName did not cause error on update');
	}

	/**
	 * Test that user is not updated with a alpha numeric last name
	 */
	public function testUpdateUserAlphaNumericLastName() {

		$user = UserFactory::insert();
		$this->attributes['lastName'] .= '0';

		$this->assertFalse($user->updateUser($this->attributes), "User with non-alphabetic lastName was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('lastName'), 'non-alphabetic lastName did not cause error on update');
	}

	/**
	 * Test that user last name is trimmed
	 */
	public function testUpdateUserTrimLastName() {

		$user = UserFactory::insert();
		$this->attributes['lastName'] = " " . $this->attributes['lastName'] . " ";

		$this->assertTrue($user->updateUser($this->attributes), "User with untrimmed lastName was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertEquals(trim($this->attributes['lastName']), $user->lastName, "User lastName was not trimmed on update");
	}

	/**
	 * Test that user timezone is set by user on Update
	 */
	public function testUpdateUserValidUserSetsTimeZone() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->timeZone, 'timeZone was not set on updateUser');
		$this->assertEquals($this->attributes['timeZone'], $user->timeZone, 'Time zone was not set by user on updateUser');
	}

	/**
	 * Test that user timezone is a timezone
	 */
	public function testUpdateUserValidUserInvalidTimeZone() {

		$user = UserFactory::insert();
		$this->attributes['timeZone'] .= StringUtils::createRandomAlphaString();

		$this->assertFalse($user->updateUser($this->attributes), "User with invalid timeZone value was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('timeZone'), 'invalid timeZone value did not cause error on update');
	}

	/**
	 * Test that user timezone only allows supported time zones
	 */
	public function testUpdateUserValidUserUnsupportedTimeZone() {

		$user = UserFactory::insert();
		$this->attributes['timeZone'] .= 'Antarctica/South_Pole';

		$this->assertFalse($user->updateUser($this->attributes), "User with antartic timeZone value was updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('timeZone'), 'antartic timeZone value did not cause error on update');
	}

	/**
	 * Test that user status is set to active by system on Update
	 */
	public function testUpdateUserValidSystemSetsStatus() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->status, 'status was not set on updateUser');
		$this->assertNotEquals($this->attributes['status'], $user->status, 'status set by user on updateUser');

		$this->assertEquals(User::STATUS_ACTIVE, $user->status, "User was not set to active on update");
	}

	/**
	 * Test that user isAdmin is set by system to false on Update
	 */
	public function testUpdateUserValidSystemSetsIsAdmin() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->isAdmin, 'isAdmin was not set on updateUser');
		$this->assertNotEquals($this->attributes['isAdmin'], $user->isAdmin, 'isAdmin set by user on updateUser');

		$this->assertEquals(0, $user->isAdmin, "User was set to admin on update");
	}

	/**
	 * Test that user created is set by system on Update
	 */
	public function testUpdateUserValidSystemSetsCreated() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->created, 'created was not set on updateUser');
		$this->assertNotEquals($this->attributes['created'], $user->created, 'created set by user on updateUser');
	}

	/**
	 * Test that user modified is set by system on Update
	 */
	public function testUpdateUserValidSystemSetsModified() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->modified, 'modified was not set on updateUser');
		$this->assertNotEquals($this->attributes['modified'], $user->modified, 'isAdmin set by user on updateUser');
	}

	/**
	 * Test that user login is ignored on Update
	 */
	public function testUpdateUserValidIgnoresLastLogin() {

		$user = UserFactory::insert();
		$this->assertTrue($user->updateUser($this->attributes), "User was not updated: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNull($user->lastLogin, 'lastLogin was set on updateUser');
	}

	/**
	 * Test that user is not saved on null attributes
	 */
	public function testUpdateUserNullAttributes() {

		$user = UserFactory::insert();
		$this->assertFalse($user->updateUser(null), "updateUser(null) return true");
	}

	/**
	 * Test that user scenario is still set on null attributes
	 */
	public function testUpdateUserNullAttributesSetsScenario() {

		$user = UserFactory::insert();
		$user->updateUser(null);
		$this->assertEquals(User::SCENARIO_UPDATE, $user->scenario);
	}

	/**
	 * Test that user scenario is still set on invalid attributes
	 */
	public function testUpdateUserInvalidAttributesSetsScenario() {

		$this->attributes['email'] = StringUtils::createRandomAlphaString();

		$user = UserFactory::insert();
		$user->updateUser($this->attributes);
		$this->assertEquals(User::SCENARIO_UPDATE, $user->scenario);
	}

	/**
	 * Test that updating a user that doesn't exist throws an exception
	 * @expectedException CDbException
	 */
	public function testUpdateUserOnNonExistingUser() {
		$user = new User();
		$user->updateUser();
	}
}