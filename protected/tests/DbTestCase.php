<?php

require_once 'TestConstants.php';

/**
 * The base class for database test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class DbTestCase extends CDbTestCase
{
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
