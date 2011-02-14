<?php

require_once 'TestConstants.php';

class CreateGroupTest extends CTestCase
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

	/**
	 * Create a valid group
	 */
    public function testCreateGroupValid() {
    	
		$name = StringUtils::createRandomString(10);
		$slug = StringUtils::createRandomString(10);
		
		$group = new Group;
	    $group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    $this->assertTrue($group->save(true), 'valid group was not saved');
	 
	    $this->assertNotNull($group->id, 'save did not set group id');
	    
	    // verify the comment is in pending status
	    $group = Group::model()->findByPk($group->id);
	    $this->assertTrue($group instanceof Group, 'found group not a Group object');
	    $this->assertEquals($name, $group->name);
	    $this->assertEquals(strtolower($slug), $group->slug);
	}
	
	/**
	 * Create a valid group
	 */
    public function testCreateGroupMaximumInputs() {
    	
		$name = StringUtils::createRandomString(255);
		$slug = StringUtils::createRandomString(50);
		
		$group = new Group;
	    $group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    $this->assertTrue($group->save(true), 'valid group was not saved');
	 
	    $this->assertNotNull($group->id, 'save did not set group id');
	    
	    // verify the comment is in pending status
	    $group = Group::model()->findByPk($group->id);
	    $this->assertTrue($group instanceof Group, 'found group not a Group object');
	    $this->assertEquals($name, $group->name);
	    $this->assertEquals(strtolower($slug), $group->slug);
	}
	
	/**
	 * Set inputs over the acceptable lengths
	 */
    public function testCreateGroupExceedMaximumInputs() {
    	
		$name = StringUtils::createRandomString(255 + 1);
		$slug = StringUtils::createRandomString(50 + 1);
		
		$group = new Group;
	    $group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    $this->assertFalse($group->save(true), 'invalid group was saved');
	    $this->assertNull($group->id, 'Unsaved group has an id');
	}
	
	/**
	 * Test group create when name and slug are blank
	 */
	public function testCreateGroupBlankInputs() {

		$name = '';
		$slug = '';
		
		$group = new Group;
	    $group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    $this->assertFalse($group->save(true), 'invalid group was saved');
	    $this->assertNull($group->id, 'Unsaved group has an id');
	}
	
	/**
	 * Test group create when no inputs are set
	 */
	public function testCreateGroupNullInputs() {

		$name = null;
		$slug = null;
		
		$group = new Group;
	    $group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,	    
	    ));
	    $this->assertFalse($group->save(true), 'invalid group was saved');
	    $this->assertNull($group->id, 'Unsaved group has an id');
	}
	
	/**
	 * Test group create when no inputs are set
	 */
	public function testCreateGroupNoInputs() {

		$group = new Group;
	    $group->setAttributes(array());
	    $this->assertFalse($group->save(true), 'invalid group was saved');
	    $this->assertNull($group->id, 'Unsaved group has an id');
	}
}