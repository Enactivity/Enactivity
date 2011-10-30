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
	 * Test that user Id is set by system on Insert
	 */
	public function testInsertUserValidSetsId() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->id, 'Id was not set on insertUser');
		$this->assertNotEquals($this->attributes['id'], $user->id, 'Id was set by user on insertUser');
	}

	/**
	 * Test that user email is set by user on Insert
	 */
	public function testInsertUserValidSetsEmail() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->email, 'email was not set on insertUser');
		$this->assertEquals($this->attributes['email'], $user->email, 'Email was not set by user on insertUser');
	}

	/**
	 * Test that user token is set by system on Insert
	 */
	public function testInsertUserValidSetsToken() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->token, 'token was not set on insertUser');
		$this->assertNotEquals($this->attributes['token'], $user->token, 'Token was set by user on insertUser');
	}

	/**
	 * Test that user password is set by user and encrypted on Insert
	 */
	public function testInsertUserValidSetsPassword() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->password, 'password was not set on insertUser');
		
		$this->assertEquals(User::encrypt($this->attributes['password'], $user->token), $user->password, 'Password was not set by user on insertUser');
		$this->assertNotEquals($this->attributes['password'], $user->password, 'Password was not encrypted on insertUser');
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
	public function testInsertUserValidSetsFirstName() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->firstName, 'firstName was not set on insertUser');
		$this->assertEquals($this->attributes['firstName'], $user->firstName, 'First name was not set by user on insertUser');
	}

	/**
	 * Test that user last name is set by user on Insert
	 */
	public function testInsertUserValidSetsLastName() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->lastName, 'lastName was not set on insertUser');
		$this->assertEquals($this->attributes['lastName'], $user->lastName, 'Last name was not set by user on insertUser');
	}

	/**
	 * Test that user timezone is set by user on Insert
	 */
	public function testInsertUserValidSetsTimeZone() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->timeZone, 'timeZone was not set on insertUser');
		$this->assertEquals($this->attributes['timeZone'], $user->timeZone, 'Time zone was not set by user on insertUser');
	}

	/**
	 * Test that user status is set to active by system on Insert
	 */
	public function testInsertUserValidSetsStatus() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->status, 'status was not set on insertUser');
		$this->assertNotEquals($this->attributes['status'], $user->status, 'status set by user on insertUser');
		
		$this->assertEquals(User::STATUS_ACTIVE, $user->status, "User was not set to active on insert");
	}

	/**
	 * Test that user isAdmin is set by system to false on Insert
	 */
	public function testInsertUserValidSetsIsAdmin() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->isAdmin, 'isAdmin was not set on insertUser');
		$this->assertNotEquals($this->attributes['isAdmin'], $user->isAdmin, 'isAdmin set by user on insertUser');
		
		$this->assertEquals(0, $user->isAdmin, "User was set to admin on insert");
	}

	/**
	 * Test that user created is set by system on Insert
	 */
	public function testInsertUserValidSetsCreated() {

		$user = new User();
		$this->assertTrue($user->insertUser($this->attributes), "User was not inserted: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->created, 'created was not set on insertUser');
		$this->assertNotEquals($this->attributes['created'], $user->created, 'created set by user on insertUser');
	}

	/**
	 * Test that user modified is set by system on Insert
	 */
	public function testInsertUserValidSetsModified() {

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
		$this->assertFalse($user->insertUser(null), "insertUser(null) was inserted");
	}

	/**
	 * Test that user is not saved on null attributes
	 */
	public function testInsertUserNullAttributesSetsScenario() {

		$user = new User();
		$user->insertUser(null);
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