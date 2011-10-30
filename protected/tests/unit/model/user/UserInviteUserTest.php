<?php
/**
 * Tests for User::inviteUser
 * @author ajsharma
 */
class UserInviteUserTest extends DbTestCase
{
	var $email;

	public function setUp() {
		parent::setUp();

		$this->email = StringUtils::createRandomEmail();
	}

	/**
	 * Test that user is saved on valid email
	 */
	public function testInviteUserValid() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));
	}

	/**
	 * Test that user Id is set by system on Invite
	 */
	public function testInviteUserValidSystemSetsId() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->id, 'Id was not set on inviteUser');
	}

	/**
	 * Test that user email is set by user on Invite
	 */
	public function testInviteUserValidUserSetsEmail() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->email, 'email was not set on inviteUser');
		$this->assertEquals($this->email, $user->email, 'Email was not set by user on inviteUser');
	}

	/**
	 * Test that user is not saved with null email
	 */
	public function testInviteUserNullEmail() {

		$user = new User();
		$this->email = null;

		$this->assertFalse($user->inviteUser($this->email), "User with null email was invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('email'), 'null email did not cause error on invite');
	}

	/**
	 * Test that user is not saved with invalid email format
	 */
	public function testInviteUserInvalidEmailFormat() {

		$user = new User();
		$this->email = StringUtils::createRandomAlphaString();

		$this->assertFalse($user->inviteUser($this->email), "User with invalid email was invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('email'), 'null email did not cause error on invite');
	}

	/**
	 * Test that user is not saved with long email
	 */
	public function testInviteUserLongEmailFormat() {

		$user = new User();
		$this->email = StringUtils::createRandomAlphaString(55) . '@alpha.poncla.com';

		$this->assertFalse($user->inviteUser($this->email), "User with invalid email was invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->getError('email'), 'null email did not cause error on invite');
	}

	/**
	 * Test that user email is trimmed
	 */
	public function testInviteUserTrimEmail() {

		$user = new User();
		$this->email = " " . $this->email . " ";

		$this->assertTrue($user->inviteUser($this->email), "User with untrimmed email was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertEquals(trim($this->email), $user->email, "User email was not trimmed on invite");
	}

	/**
	 * Test that user token is set by system on Invite
	 */
	public function testInviteUserValidSystemSetsToken() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->token, 'token was not set on inviteUser');
		$this->assertNotEmpty($user->token, 'token was not set on inviteUser');
	}

	/**
	 * Test that user password is ignored on Invite
	 */
	public function testInviteUserValidIgnoresPassword() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNull($user->password, 'password was set on inviteUser');
	}

	/**
	 * Test that user confirmPassword cannot be set by user on Invite
	 */
	public function testInviteUserValidIgnoresConfirmPassword() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNull($user->confirmPassword, 'confirmPassword was set on inviteUser');
	}

	/**
	 * Test that user first name cannot be set by user on Invite
	 */
	public function testInviteUserValidIgnoresFirstName() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNull($user->firstName, 'firstName was set on inviteUser');
	}

	/**
	 * Test that user last name cannot be set by user on Invite
	 */
	public function testInviteUserValidIgnoresLastName() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNull($user->lastName, 'lastName was set on inviteUser');
	}

	/**
	 * Test that user timezone is set by system on Invite
	 */
	public function testInviteUserValidSystemSetsTimeZone() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->timeZone, 'timeZone was not set on inviteUser');
		$this->assertEquals('America/Los_Angeles', $user->timeZone, 'Time zone was not set to Pacific by user on inviteUser');
	}

	/**
	 * Test that user status is set to pending by system on Invite
	 */
	public function testInviteUserValidSystemSetsStatus() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->status, 'status was not set on inviteUser');

		$this->assertEquals(User::STATUS_PENDING, $user->status, "User was not set to pending on invite");
	}

	/**
	 * Test that user isAdmin is set by system to false on Invite
	 */
	public function testInviteUserValidSystemSetsIsAdmin() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->isAdmin, 'isAdmin was not set on inviteUser');
		$this->assertEquals(0, $user->isAdmin, "User was set to admin on invite");
	}

	/**
	 * Test that user created is set by system on Invite
	 */
	public function testInviteUserValidSystemSetsCreated() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->created, 'created was not set on inviteUser');
	}

	/**
	 * Test that user modified is set by system on Invite
	 */
	public function testInviteUserValidSystemSetsModified() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNotNull($user->modified, 'modified was not set on inviteUser');
	}

	/**
	 * Test that user login is ignored on Invite
	 */
	public function testInviteUserValidIgnoresLastLogin() {

		$user = new User();
		$this->assertTrue($user->inviteUser($this->email), "User was not invited: " . CVarDumper::dumpAsString($user->errors));

		$this->assertNull($user->lastLogin, 'lastLogin was set on inviteUser');
	}

	/**
	 * Test that user is not saved on null attributes
	 */
	public function testInviteUserNullAttributes() {

		$user = new User();
		$this->assertFalse($user->inviteUser(null), "inviteUser(null) return true");
	}

	/**
	 * Test that user is not saved on null attributes
	 */
	public function testInviteUserNullAttributesSetsScenario() {

		$user = new User();
		$user->inviteUser(null);
		$this->assertEquals(User::SCENARIO_INVITE, $user->scenario);
	}

	/**
	 * Test that user is not saved on invalid attributes
	 */
	public function testInviteUserInvalidAttributesSetsScenario() {

		$this->email = StringUtils::createRandomAlphaString();

		$user = new User();
		$user->inviteUser($this->email);
		$this->assertEquals(User::SCENARIO_INVITE, $user->scenario);
	}

	/**
	 * Test that invite a user that already exists throws an exception
	 * @expectedException CDbException
	 */
	public function testInviteUserOnExistingUser() {
		$user = UserFactory::insert();
		$user->inviteUser($this->email);
	}
}