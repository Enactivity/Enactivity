<?php

require_once 'TestConstants.php';

/**
 * The base class for database test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class DbTestCase extends CDbTestCase
{
	public $fixtures = array(
		'groupFixtures'=>':group',
		'userFixtures'=>':user',
		'groupUserFixtures'=>':group_user',
		'taskFixtures'=>':task',
		'taskUserFixtures'=>':task_user',
		'activeRecordLogFixtures'=>':activerecordlog',
		'commentFixtures'=>':comment',
    );
    
	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
	}
    
	/**
	 * Sets up before each test method runs.
	 * This mainly sets the base URL for the test application.
	 */
	protected function setUp()
	{
		parent::setUp();
		
		// login as registered user
		$loginForm = new UserLoginForm();
		$loginForm->email = $this->userFixtures['registered']['email'];
		$loginForm->password = 'test';
		$loginForm->login();
	}
	
	protected function tearDown()
	{
		parent::tearDown();
	}
 
    public static function tearDownAfterClass()
    {
    	parent::tearDownAfterClass();
    }
}
