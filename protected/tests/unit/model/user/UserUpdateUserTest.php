<?php
/**
 * Tests for {@link User::updateUser}
 * @author ajsharma
 */
class UserUpdateUserTest extends DbTestCase
{
	var $user;
	var $userId;
	var $userCreated;
	var $userModified;

	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
	}
	
	protected function setUp()
	{
		parent::setUp();
		
		// get the registered user
		$this->user = UserFactory::insert();
		$this->userId = $this->user->id;
		$this->userCreated = $this->user->created;
		$this->userModified = $this->user->modified;
	}
	
	protected function tearDown()
	{
		parent::tearDown();
	}
 
	public static function tearDownAfterClass()
	{
		parent::tearDownAfterClass();
	}
	
	/**
	 * Create a valid user
	 */
	public function testUpdateUserValid() {
		
		$email = strtolower(StringUtils::createRandomString(10)) . '@fakeyfaky.com';
		$firstName = StringUtils::createRandomString(10);
		$lastName = StringUtils::createRandomString(10);
		
		$attributes = array(
			'email' => $email,
			'firstName' => $firstName,
			'lastName' => $lastName,
		);
		
		sleep(1); // to allow time for modified to update
		
		$this->assertTrue($this->user->updateUser($attributes), 'valid user was not saved');
		$this->assertEquals($this->userId, $this->user->id, 
			'updating save changed user id');
		
		// verify the user can be found in db 
		$this->user = User::model()->findByPk($this->user->id);
		
		$this->assertTrue($this->user instanceof User, 'found user not a User object');
		
		$this->assertEquals($email, $this->user->email, 
			'user email was not saved');
		$this->assertEquals($firstName, $this->user->firstName, 
			'user first name was not saved');
		$this->assertEquals($lastName, $this->user->lastName, 
			'user last name was not saved');
		
		$this->assertEquals($this->userCreated, $this->user->created, 
			'user created was changed on update');
		$this->assertNotEquals($this->userModified, $this->user->modified, 
			'user modified was not changed on update');
	}
	
	/**
	 * Create a valid user and ensure entries are trimmed
	 */
	public function testUpdateUserTrimSpaces() {

		$email = strtolower(StringUtils::createRandomString(10)) . '@fakeyfaky.com';
		$firstName = StringUtils::createRandomString(10);
		$lastName = StringUtils::createRandomString(10);
		
		$attributes = array(
			'email' => ' ' . $email . ' ',
			'firstName' => ' ' . $firstName . ' ',
			'lastName' => ' ' . $lastName . ' ',
		);
		
		$this->assertTrue($this->user->updateUser($attributes), 'valid user was not saved');
		$this->assertEquals($this->userId, $this->user->id, 
			'updating save changed user id');
		
		// verify the user can be found in db 
		$this->user = User::model()->findByPk($this->user->id);
		
		$this->assertTrue($this->user instanceof User, 'found user not a User object');
		
		$this->assertEquals($email, $this->user->email, 
			'user email was not trimmed');
		$this->assertEquals($firstName, $this->user->firstName, 
			'user first name was not trimmed');
		$this->assertEquals($lastName, $this->user->lastName, 
			'user last name was not trimmed');
	}
	
	/**
	 * Create a valid user
	 */
	public function testUpdateUserMaximumInputs() {
		$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
	}
	
	/**
	 * Set inputs over the acceptable lengths
	 */
	public function testUpdateUserExceedMaximumInputs() {
		$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
	}
	
	/**
	 * Test user create when name and slug are blank
	 */
	public function testUpdateUserBlankInputs() {
		$this->markTestIncomplete(
		          'This test has not been implemented yet.'
		);
	}
	
	/**
	 * Test user create when no inputs are set
	 */
	public function testUpdateUserNullInputs() {
		$this->markTestIncomplete(
		          'This test has not been implemented yet.'
		);
	}
	
	/**
	 * Test user create when no inputs are set
	 */
	public function testUpdateUserNoName() {
		$this->markTestIncomplete(
		          'This test has not been implemented yet.'
		);
	}
	
	/**
	 * Test user create when no inputs are set
	 */
	public function testUpdateUserNoSlug() {
		$this->markTestIncomplete(
		          'This test has not been implemented yet.'
		);
	}
	
	/**
	 * Test that users with duplicate names cannot be saved
	 */
	public function testUpdateUserDuplicateToken() {
		$this->markTestIncomplete(
		          'This test has not been implemented yet.'
		);
	}
}