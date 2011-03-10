<?php

require_once 'TestConstants.php';

class UpdateUserTest extends DbTestCase
{
	public $user;
	
	public $fixtures = array(
		'users'=>'User',
	);
	
	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
	}
	
	protected function setUp()
	{
		parent::setUp();
		
		// get the registered user
		$this->user = User::model()->findByPk($this->users['registered']['id']);
		
		$this->user->scenario = User::SCENARIO_UPDATE;
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
		
		$this->user->setAttributes(array(
			'email' => $email,
			'firstName' => $firstName,
			'lastName' => $lastName,
		));
		
		$this->assertTrue($this->user->save(), 'valid user was not saved');
		$this->assertEquals($this->users['registered']['id'], $this->user->id, 
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
		
		$this->assertEquals($this->users['registered']['created'], $this->user->created, 
			'user created was changed on update');
		$this->assertNotEquals($this->users['registered']['modified'], $this->user->modified, 
			'user modified was not changed on update');
	}
	
	/**
	 * Create a valid user and ensure entries are trimmed
	 */
	public function testUpdateUserTrimSpaces() {

		$email = strtolower(StringUtils::createRandomString(10)) . '@fakeyfaky.com';
		$firstName = StringUtils::createRandomString(10);
		$lastName = StringUtils::createRandomString(10);
		
		$this->user->setAttributes(array(
			'email' => ' ' . $email . ' ',
			'firstName' => ' ' . $firstName . ' ',
			'lastName' => ' ' . $lastName . ' ',
		));
		
		$this->assertTrue($this->user->save(), 'valid user was not saved');
		$this->assertEquals($this->users['registered']['id'], $this->user->id, 
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
		
	}
	
	/**
	 * Set inputs over the acceptable lengths
	 */
	public function testUpdateUserExceedMaximumInputs() {

	}
	
	/**
	 * Test user create when name and slug are blank
	 */
	public function testUpdateUserBlankInputs() {

	}
	
	/**
	 * Test user create when no inputs are set
	 */
	public function testUpdateUserNullInputs() {

	}
	
	/**
	 * Test user create when no inputs are set
	 */
	public function testUpdateUserNoName() {

	}
	
	/**
	 * Test user create when no inputs are set
	 */
	public function testUpdateUserNoSlug() {

	}
	
	/**
	 * Test that users with duplicate names cannot be saved
	 */
	public function testUpdateUserDuplicateToken() {

	}
}