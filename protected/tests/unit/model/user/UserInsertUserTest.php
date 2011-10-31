<?php
/**
 * Tests for User::insertUser
 * @author ajsharma
 */
class UserInsertUserTest extends DbTestCase
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
	 * Test that user is inserted on valid attributes
	 */
	public function testInsertUserValid() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));
	}

	/**
	 * Test that user Id is set by system on Insert
	 */
	public function testInsertUserValidSystemSetsId() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->id, 'Id was not set on insertUser');
		$this->assertNotEquals($this->attributes['id'], $user->id, 'Id was set by user on insertUser');
	}

	/**
	 * Test that user email is set by user on Insert
	 */
	public function testInsertUserValidUserSetsEmail() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->email, 'email was not set on insertUser');
		$this->assertEquals($this->attributes['email'], $user->email, 'Email was not set by user on insertUser');
	}

	/**
	 * Test that user is not inserted with null email
	 */
	public function testInsertUserNullEmail() {

		$user = new User();
		$this->attributes['email'] = null;

		$this->assertFalse($user->insertUser($this->attributes), "User with null email was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('email'), 'null email did not cause error on insert');
	}

	/**
	 * Test that user is not inserted with invalid email format
	 */
	public function testInsertUserInvalidEmailFormat() {

		$user = new User();
		$this->attributes['email'] = StringUtils::createRandomAlphaString();

		$this->assertFalse($user->insertUser($this->attributes), "User with invalid email was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('email'), 'null email did not cause error on insert');
	}

	/**
	 * Test that user is not inserted with long email
	 */
	public function testInsertUserLongEmailFormat() {

		$user = new User();
		$this->attributes['email'] = StringUtils::createRandomAlphaString(55) . '@alpha.poncla.com';

		$this->assertFalse($user->insertUser($this->attributes), "User with invalid email was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('email'), 'null email did not cause error on insert');
	}

	/**
	 * Test that user email is trimmed
	 */
	public function testInsertUserTrimEmail() {

		$user = new User();
		$this->attributes['email'] = " " . $this->attributes['email'] . " ";

		$this->assertTrue($user->insertUser($this->attributes), "User with untrimmed email was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertEquals(trim($this->attributes['email']), $user->email, "User email was not trimmed on insert");
	}

	/**
	 * Test that user token is set by system on Insert
	 */
	public function testInsertUserValidSystemSetsToken() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->token, 'token was not set on insertUser');
		$this->assertNotEquals($this->attributes['token'], $user->token, 'Token was set by user on insertUser');
	}

	/**
	 * Test that user password is set by user and encrypted on Insert
	 */
	public function testInsertUserValidUserSetsPassword() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->password, 'password was not set on insertUser');

		$this->assertEquals(User::encrypt($this->attributes['password'], $user->token), $user->password, 'Password was not set by user on insertUser');
		$this->assertNotEquals($this->attributes['password'], $user->password, 'Password was not encrypted on insertUser');
	}

	/**
	 * Test that user is not inserted with null password
	 */
	public function testInsertUserNullPassword() {

		$user = new User();
		$this->attributes['password'] = null;

		$this->assertFalse($user->insertUser($this->attributes), "User with null password was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('password'), 'null password did not cause error on insert');
	}

	/**
	 * Test that user is not inserted with too short password
	 */
	public function testInsertUserShortPassword() {

		$user = new User();
		$this->attributes['password'] = StringUtils::createRandomAlphaString(3);

		$this->assertFalse($user->insertUser($this->attributes), "User with short password was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('password'), 'null password did not cause error on insert');
	}

	/**
	 * Test that user is not inserted with too long password
	 */
	public function testInsertUserLongPassword() {

		$user = new User();
		$this->attributes['password'] = StringUtils::createRandomAlphaString(45);

		$this->assertFalse($user->insertUser($this->attributes), "User with long password was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('password'), 'null password did not cause error on insert');
	}

	/**
	 * Test that user confirmPassword is not set by user on Insert
	 */
	public function testInsertUserValidIgnoresConfirmPassword() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNull($user->confirmPassword, 'confirmPassword was set on insertUser');
		$this->assertNotEquals($this->attributes['confirmPassword'], $user->confirmPassword, 'confirmPassword set by user on insertUser');
	}

	/**
	 * Test that user first name is set by user on Insert
	 */
	public function testInsertUserValidUserSetsFirstName() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->firstName, 'firstName was not set on insertUser');
		$this->assertEquals($this->attributes['firstName'], $user->firstName, 'First name was not set by user on insertUser');
	}

	/**
	 * Test that user is not inserted with too short first name
	 */
	public function testInsertUserShortFirstName() {

		$user = new User();
		$this->attributes['firstName'] = StringUtils::createRandomAlphaString(1);

		$this->assertFalse($user->insertUser($this->attributes), "User with short firstName was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('firstName'), 'short firstName did not cause error on insert');
	}

	/**
	 * Test that user is not inserted with too long first name
	 */
	public function testInsertUserLongFirstName() {

		$user = new User();
		$this->attributes['firstName'] = StringUtils::createRandomAlphaString(55);

		$this->assertFalse($user->insertUser($this->attributes), "User with long firstName was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('firstName'), 'long firstName did not cause error on insert');
	}

	/**
	 * Test that user is not inserted with a alpha numeric first name
	 */
	public function testInsertUserAlphaNumericFirstName() {

		$user = new User();
		$this->attributes['firstName'] .= '0';

		$this->assertFalse($user->insertUser($this->attributes), "User with non-alphabetic firstName was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('firstName'), 'non-alphabetic firstName did not cause error on insert');
	}

	/**
	 * Test that user firstname is trimmed
	 */
	public function testInsertUserTrimFirstName() {

		$user = new User();
		$this->attributes['firstName'] = " " . $this->attributes['firstName'] . " ";

		$this->assertTrue($user->insertUser($this->attributes), "User with untrimmed firstName was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertEquals(trim($this->attributes['firstName']), $user->firstName, "User firstName was not trimmed on insert");
	}

	/**
	 * Test that user last name is set by user on Insert
	 */
	public function testInsertUserValidUserSetsLastName() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->lastName, 'lastName was not set on insertUser');
		$this->assertEquals($this->attributes['lastName'], $user->lastName, 'Last name was not set by user on insertUser');
	}

	/**
	 * Test that user is not inserted with too short last name
	 */
	public function testInsertUserShortLastName() {

		$user = new User();
		$this->attributes['lastName'] = StringUtils::createRandomAlphaString(1);

		$this->assertFalse($user->insertUser($this->attributes), "User with short lastName was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('lastName'), 'short lastName did not cause error on insert');
	}

	/**
	 * Test that user is not inserted with too long last name
	 */
	public function testInsertUserLongLastName() {

		$user = new User();
		$this->attributes['lastName'] = StringUtils::createRandomAlphaString(55);

		$this->assertFalse($user->insertUser($this->attributes), "User with long lastName was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('lastName'), 'long lastName did not cause error on insert');
	}

	/**
	 * Test that user is not inserted with a alpha numeric last name
	 */
	public function testInsertUserAlphaNumericLastName() {

		$user = new User();
		$this->attributes['lastName'] .= '0';

		$this->assertFalse($user->insertUser($this->attributes), "User with non-alphabetic lastName was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('lastName'), 'non-alphabetic lastName did not cause error on insert');
	}

	/**
	 * Test that user last name is trimmed
	 */
	public function testInsertUserTrimLastName() {

		$user = new User();
		$this->attributes['lastName'] = " " . $this->attributes['lastName'] . " ";

		$this->assertTrue($user->insertUser($this->attributes), "User with untrimmed lastName was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertEquals(trim($this->attributes['lastName']), $user->lastName, "User lastName was not trimmed on insert");
	}

	/**
	 * Test that user timezone is set by user on Insert
	 */
	public function testInsertUserValidUserSetsTimeZone() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->timeZone, 'timeZone was not set on insertUser');
		$this->assertEquals($this->attributes['timeZone'], $user->timeZone, 'Time zone was not set by user on insertUser');
	}

	/**
	 * Test that user timezone is a timezone
	 */
	public function testInsertUserValidUserInvalidTimeZone() {

		$user = new User();
		$this->attributes['timeZone'] .= StringUtils::createRandomAlphaString();

		$this->assertFalse($user->insertUser($this->attributes), "User with invalid timeZone value was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('timeZone'), 'invalid timeZone value did not cause error on insert');
	}

	/**
	 * Test that user timezone only allows supported time zones
	 */
	public function testInsertUserValidUserUnsupportedTimeZone() {

		$user = new User();
		$this->attributes['timeZone'] .= 'Antarctica/South_Pole';

		$this->assertFalse($user->insertUser($this->attributes), "User with antartic timeZone value was inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('timeZone'), 'antartic timeZone value did not cause error on insert');
	}

	/**
	 * Test that user status is set to active by system on Insert
	 */
	public function testInsertUserValidSystemSetsStatus() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->status, 'status was not set on insertUser');
		$this->assertNotEquals($this->attributes['status'], $user->status, 'status set by user on insertUser');

		$this->assertEquals(User::STATUS_ACTIVE, $user->status, "User was not set to active on insert");
	}

	/**
	 * Test that user isAdmin is set by system to false on Insert
	 */
	public function testInsertUserValidSystemSetsIsAdmin() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->isAdmin, 'isAdmin was not set on insertUser');
		$this->assertNotEquals($this->attributes['isAdmin'], $user->isAdmin, 'isAdmin set by user on insertUser');

		$this->assertEquals(0, $user->isAdmin, "User was set to admin on insert");
	}

	/**
	 * Test that user created is set by system on Insert
	 */
	public function testInsertUserValidSystemSetsCreated() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->created, 'created was not set on insertUser');
		$this->assertNotEquals($this->attributes['created'], $user->created, 'created set by user on insertUser');
	}

	/**
	 * Test that user modified is set by system on Insert
	 */
	public function testInsertUserValidSystemSetsModified() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->modified, 'modified was not set on insertUser');
		$this->assertNotEquals($this->attributes['modified'], $user->modified, 'isAdmin set by user on insertUser');
	}

	/**
	 * Test that user login is ignored on Insert
	 */
	public function testInsertUserValidIgnoresLastLogin() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNull($user->lastLogin, 'lastLogin was set on insertUser');
	}

	/**
	 * Test that user is not saved on null attributes
	 */
	public function testInsertUserNullAttributes() {

		$user = new User();
		$this->assertFalse($user->insertUser(null), "insertUser(null) return true");
	}

	/**
	 * Test that user scenario is still set on null attributes
	 */
	public function testInsertUserNullAttributesSetsScenario() {

		$user = new User();
		$user->insertUser(null);
		$this->assertEquals(User::SCENARIO_INSERT, $user->scenario);
	}

	/**
	 * Test that user scenario is still set on invalid attributes
	 */
	public function testInsertUserInvalidAttributesSetsScenario() {

		$this->attributes['email'] = StringUtils::createRandomAlphaString();

		$user = new User();
		$user->insertUser($this->attributes);
		$this->assertEquals(User::SCENARIO_INSERT, $user->scenario);
	}

	/**
	 * Test that inserting a user that already exists throws an exception
	 * @expectedException CDbException
	 */
	public function testInsertUserOnExistingUser() {
		$user = UserFactory::insert();
		$user->insertUser();
	}
}