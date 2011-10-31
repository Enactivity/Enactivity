<?php
/**
 * Tests for User::registerUser
 * @author ajsharma
 */
class UserRegisterUserTest extends DbTestCase
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
	 * Test that user is registered on valid attributes
	 */
	public function testRegisterUserValid() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));
	}

	/**
	 * Test that user Id is set by system on Insert
	 */
	public function testRegisterUserValidSystemSetsId() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->id, 'Id was not set on RegisterUser');
		$this->assertNotEquals($this->attributes['id'], $user->id, 'Id was set by user on RegisterUser');
	}

	/**
	 * Test that user email is set by user on Insert
	 */
	public function testRegisterUserValidUserSetsEmail() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->email, 'email was not set on RegisterUser');
		$this->assertEquals($this->attributes['email'], $user->email, 'Email was not set by user on RegisterUser');
	}

	/**
	 * Test that user is not registered with null email
	 */
	public function testRegisterUserNullEmail() {

		$user = UserFactory::insertInvited();
		$this->attributes['email'] = null;

		$this->assertFalse($user->registerUser($this->attributes), "User with null email was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('email'), 'null email did not cause error on insert');
	}

	/**
	 * Test that user is not registered with invalid email format
	 */
	public function testRegisterUserInvalidEmailFormat() {

		$user = UserFactory::insertInvited();
		$this->attributes['email'] = StringUtils::createRandomAlphaString();

		$this->assertFalse($user->registerUser($this->attributes), "User with invalid email was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('email'), 'null email did not cause error on insert');
	}

	/**
	 * Test that user is not registered with long email
	 */
	public function testRegisterUserLongEmailFormat() {

		$user = UserFactory::insertInvited();
		$this->attributes['email'] = StringUtils::createRandomAlphaString(55) . '@alpha.poncla.com';

		$this->assertFalse($user->registerUser($this->attributes), "User with invalid email was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('email'), 'null email did not cause error on insert');
	}

	/**
	 * Test that user email is trimmed
	 */
	public function testRegisterUserTrimEmail() {

		$user = UserFactory::insertInvited();
		$this->attributes['email'] = " " . $this->attributes['email'] . " ";

		$this->assertTrue($user->registerUser($this->attributes), "User with untrimmed email was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertEquals(trim($this->attributes['email']), $user->email, "User email was not trimmed on insert");
	}

	/**
	 * Test that user token is set by system on Insert
	 */
	public function testRegisterUserValidSystemSetsToken() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->token, 'token was not set on RegisterUser');
		$this->assertNotEquals($this->attributes['token'], $user->token, 'Token was set by user on RegisterUser');
	}

	/**
	 * Test that user password is set by user and encrypted on Insert
	 */
	public function testRegisterUserValidUserSetsPassword() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->password, 'password was not set on RegisterUser');

		$this->assertEquals(User::encrypt($this->attributes['password'], $user->token), $user->password, 'Password was not set by user on RegisterUser');
		$this->assertNotEquals($this->attributes['password'], $user->password, 'Password was not encrypted on RegisterUser');
	}

	/**
	 * Test that user is not registered with null password
	 */
	public function testRegisterUserNullPassword() {

		$user = UserFactory::insertInvited();
		$this->attributes['password'] = null;

		$this->assertFalse($user->registerUser($this->attributes), "User with null password was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('password'), 'null password did not cause error on insert');
	}

	/**
	 * Test that user is not registered with too short password
	 */
	public function testRegisterUserShortPassword() {

		$user = UserFactory::insertInvited();
		$this->attributes['password'] = StringUtils::createRandomAlphaString(3);

		$this->assertFalse($user->registerUser($this->attributes), "User with short password was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('password'), 'null password did not cause error on insert');
	}

	/**
	 * Test that user is not registered with too long password
	 */
	public function testRegisterUserLongPassword() {

		$user = UserFactory::insertInvited();
		$this->attributes['password'] = StringUtils::createRandomAlphaString(45);

		$this->assertFalse($user->registerUser($this->attributes), "User with long password was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('password'), 'null password did not cause error on insert');
	}

	/**
	 * Test that user confirmPassword is not set by user on Insert
	 */
	public function testRegisterUserValidConfirmPassword() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->confirmPassword, 'confirmPassword was not set on RegisterUser');
		$this->assertEquals($this->attributes['confirmPassword'], $user->confirmPassword, 'confirmPassword not set by user on RegisterUser');
	}

	/**
	 * Test that user confirmPassword is not set by user on Insert
	 */
	public function testRegisterUserValidNullConfirmPassword() {

		$user = UserFactory::insertInvited();
		$this->attributes['confirmPassword'] = null;

		$this->assertFalse($user->registerUser($this->attributes), "User was registered with null confirm password: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNull($user->confirmPassword, 'confirmPassword was not set on RegisterUser');
		$this->assertEquals($this->attributes['confirmPassword'], $user->confirmPassword, 'confirmPassword not set by user on RegisterUser');
	}

	/**
	 * Test that user first name is set by user on Insert
	 */
	public function testRegisterUserValidUserSetsFirstName() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->firstName, 'firstName was not set on RegisterUser');
		$this->assertEquals($this->attributes['firstName'], $user->firstName, 'First name was not set by user on RegisterUser');
	}

	/**
	 * Test that user is not registered with too short first name
	 */
	public function testRegisterUserShortFirstName() {

		$user = UserFactory::insertInvited();
		$this->attributes['firstName'] = StringUtils::createRandomAlphaString(1);

		$this->assertFalse($user->registerUser($this->attributes), "User with short firstName was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('firstName'), 'short firstName did not cause error on insert');
	}

	/**
	 * Test that user is not registered with too long first name
	 */
	public function testRegisterUserLongFirstName() {

		$user = UserFactory::insertInvited();
		$this->attributes['firstName'] = StringUtils::createRandomAlphaString(55);

		$this->assertFalse($user->registerUser($this->attributes), "User with long firstName was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('firstName'), 'long firstName did not cause error on insert');
	}

	/**
	 * Test that user is not registered with a alpha numeric first name
	 */
	public function testRegisterUserAlphaNumericFirstName() {

		$user = UserFactory::insertInvited();
		$this->attributes['firstName'] .= '0';

		$this->assertFalse($user->registerUser($this->attributes), "User with non-alphabetic firstName was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('firstName'), 'non-alphabetic firstName did not cause error on insert');
	}

	/**
	 * Test that user firstname is trimmed
	 */
	public function testRegisterUserTrimFirstName() {

		$user = UserFactory::insertInvited();
		$this->attributes['firstName'] = " " . $this->attributes['firstName'] . " ";

		$this->assertTrue($user->registerUser($this->attributes), "User with untrimmed firstName was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertEquals(trim($this->attributes['firstName']), $user->firstName, "User firstName was not trimmed on insert");
	}

	/**
	 * Test that user last name is set by user on Insert
	 */
	public function testRegisterUserValidUserSetsLastName() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->lastName, 'lastName was not set on RegisterUser');
		$this->assertEquals($this->attributes['lastName'], $user->lastName, 'Last name was not set by user on RegisterUser');
	}

	/**
	 * Test that user is not registered with too short last name
	 */
	public function testRegisterUserShortLastName() {

		$user = UserFactory::insertInvited();
		$this->attributes['lastName'] = StringUtils::createRandomAlphaString(1);

		$this->assertFalse($user->registerUser($this->attributes), "User with short lastName was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('lastName'), 'short lastName did not cause error on insert');
	}

	/**
	 * Test that user is not registered with too long last name
	 */
	public function testRegisterUserLongLastName() {

		$user = UserFactory::insertInvited();
		$this->attributes['lastName'] = StringUtils::createRandomAlphaString(55);

		$this->assertFalse($user->registerUser($this->attributes), "User with long lastName was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('lastName'), 'long lastName did not cause error on insert');
	}

	/**
	 * Test that user is not registered with a alpha numeric last name
	 */
	public function testRegisterUserAlphaNumericLastName() {

		$user = UserFactory::insertInvited();
		$this->attributes['lastName'] .= '0';

		$this->assertFalse($user->registerUser($this->attributes), "User with non-alphabetic lastName was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('lastName'), 'non-alphabetic lastName did not cause error on insert');
	}

	/**
	 * Test that user last name is trimmed
	 */
	public function testRegisterUserTrimLastName() {

		$user = UserFactory::insertInvited();
		$this->attributes['lastName'] = " " . $this->attributes['lastName'] . " ";

		$this->assertTrue($user->registerUser($this->attributes), "User with untrimmed lastName was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertEquals(trim($this->attributes['lastName']), $user->lastName, "User lastName was not trimmed on insert");
	}

	/**
	 * Test that user timezone is set by user on Insert
	 */
	public function testRegisterUserValidUserSetsTimeZone() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->timeZone, 'timeZone was not set on RegisterUser');
		$this->assertEquals($this->attributes['timeZone'], $user->timeZone, 'Time zone was not set by user on RegisterUser');
	}

	/**
	 * Test that user timezone is a timezone
	 */
	public function testRegisterUserValidUserInvalidTimeZone() {

		$user = UserFactory::insertInvited();
		$this->attributes['timeZone'] .= StringUtils::createRandomAlphaString();

		$this->assertFalse($user->registerUser($this->attributes), "User with invalid timeZone value was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('timeZone'), 'invalid timeZone value did not cause error on insert');
	}

	/**
	 * Test that user timezone only allows supported time zones
	 */
	public function testRegisterUserValidUserUnsupportedTimeZone() {

		$user = UserFactory::insertInvited();
		$this->attributes['timeZone'] .= 'Antarctica/South_Pole';

		$this->assertFalse($user->registerUser($this->attributes), "User with antartic timeZone value was registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('timeZone'), 'antartic timeZone value did not cause error on insert');
	}

	/**
	 * Test that user status is set to active by system on Insert
	 */
	public function testRegisterUserValidSystemSetsStatus() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->status, 'status was not set on RegisterUser');
		$this->assertNotEquals($this->attributes['status'], $user->status, 'status set by user on RegisterUser');

		$this->assertEquals(User::STATUS_ACTIVE, $user->status, "User was not set to active on insert");
	}

	/**
	 * Test that user isAdmin is set by system to false on Insert
	 */
	public function testRegisterUserValidSystemSetsIsAdmin() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->isAdmin, 'isAdmin was not set on RegisterUser');
		$this->assertNotEquals($this->attributes['isAdmin'], $user->isAdmin, 'isAdmin set by user on RegisterUser');

		$this->assertEquals(0, $user->isAdmin, "User was set to admin on insert");
	}

	/**
	 * Test that user created is set by system on Insert
	 */
	public function testRegisterUserValidSystemSetsCreated() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->created, 'created was not set on RegisterUser');
		$this->assertNotEquals($this->attributes['created'], $user->created, 'created set by user on RegisterUser');
	}

	/**
	 * Test that user modified is set by system on Insert
	 */
	public function testRegisterUserValidSystemSetsModified() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->modified, 'modified was not set on RegisterUser');
		$this->assertNotEquals($this->attributes['modified'], $user->modified, 'isAdmin set by user on RegisterUser');
	}

	/**
	 * Test that user login is ignored on Insert
	 */
	public function testRegisterUserValidIgnoresLastLogin() {

		$user = UserFactory::insertInvited();
		$this->assertTrue($user->registerUser($this->attributes), "User was not registered: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNull($user->lastLogin, 'lastLogin was set on RegisterUser');
	}

	/**
	 * Test that user is not saved on null attributes
	 */
	public function testRegisterUserNullAttributes() {

		$user = UserFactory::insertInvited();
		$this->assertFalse($user->registerUser(null), "RegisterUser(null) return true");
	}

	/**
	 * Test that user scenario is still set on null attributes
	 */
	public function testRegisterUserNullAttributesSetsScenario() {

		$user = UserFactory::insertInvited();
		$user->registerUser(null);
		$this->assertEquals(User::SCENARIO_REGISTER, $user->scenario);
	}

	/**
	 * Test that user scenario is still set on invalid attributes
	 */
	public function testRegisterUserInvalidAttributesSetsScenario() {

		$this->attributes['email'] = StringUtils::createRandomAlphaString();

		$user = UserFactory::insertInvited();
		$user->registerUser($this->attributes);
		$this->assertEquals(User::SCENARIO_REGISTER, $user->scenario);
	}

	/**
	 * Test that registering a new user throws an exception
	 * @expectedException CDbException
	 */
	public function testRegisterUserOnNewUser() {
		$user = new User();
		$user->registerUser();
	}

	/**
	 * Test that registering a user that is already registered throws an exception
	 * @expectedException CHttpException
	 */
	public function testRegisterUserOnActiveUser() {
		$user = UserFactory::insert();
		$user->registerUser();
	}
}