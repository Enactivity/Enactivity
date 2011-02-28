<?php

require_once 'TestConstants.php';

class CreateGroupTest extends DbTestCase
{

	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
		
//		$_identity=new UserIdentity($login,$password);
//		$return = $_identity->authenticate();
//		$this->assertTrue($return);
//		$this->assertEquals(1, Yii::app()->user->id);
	}
    
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
	    $this->assertTrue($group->save(), 'valid group was not saved');
	    $this->assertNotNull($group->id, 'save did not set group id');
	    
	    // verify the group can be found in db 
	    $group = Group::model()->findByPk($group->id);
	    
	    $this->assertTrue($group instanceof Group, 'found group not a Group object');
	    
	    $this->assertEquals($name, $group->name, 'group name was not saved');
	    $this->assertEquals(strtolower($slug), $group->slug, 'group slug was not saved');
	    
	    $this->assertNotNull($group->created, 'group created was not set');
	    $this->assertNotNull($group->modified, 'group modified was not set');
	}
	
	/**
	 * Create a valid group and ensure entries are trimmed
	 */
    public function testCreateGroupTrimSpaces() {
    	
		$name = StringUtils::createRandomString(10);
		$slug = StringUtils::createRandomString(10);
		
		$paddedName = ' ' . $name . ' ';
		$paddedSlug = ' ' . $slug . ' ';
		
		$group = new Group;
	    $group->setAttributes(array(
	        'name' => $paddedName,
	        'slug' => $paddedSlug,
	    ));
	    
	    $this->assertTrue($group->save(), 'valid group was not saved');
	    $this->assertNotNull($group->id, 'save did not set group id');
	    
	    // verify the group can be found in db 
	    $group = Group::model()->findByPk($group->id);
	    
	    $this->assertTrue($group instanceof Group, 'found group not a Group object');
	    
	    $this->assertEquals($name, $group->name, 'name was not trimmed');
	    $this->assertEquals(strtolower($slug), $group->slug, 'slug was not trimmed');
	    
	    $this->assertNotNull($group->created, 'group created was not set');
	    $this->assertNotNull($group->modified, 'group modified was not set');
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
	    $this->assertTrue($group->save(), 'valid group was not saved');
	 
	    $this->assertNotNull($group->id, 'save did not set group id');
	    
	    // verify the group can be found in db 
	    $group = Group::model()->findByPk($group->id);
	    
	    $this->assertTrue($group instanceof Group, 'found group not a Group object');
		
	    $this->assertEquals($name, $group->name, 'group name was not saved');
	    $this->assertEquals(strtolower($slug), $group->slug, 'group slug was not saved');
	    
	    $this->assertNotNull($group->created, 'group created was not set');
	    $this->assertNotNull($group->modified, 'group modified was not set');
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
	    $this->assertFalse($group->save(), 'invalid group was saved');
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
	    
	    $this->assertFalse($group->save(), 'invalid group was saved');
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
	    $this->assertFalse($group->save(), 'invalid group was saved');
	    $this->assertNull($group->id, 'Unsaved group has an id');
	}
	
	/**
	 * Test group create when no inputs are set
	 */
	public function testCreateGroupNoInputs() {

		$group = new Group;
	    $group->setAttributes(array());
	    $this->assertFalse($group->save(), 'invalid group was saved');
	    $this->assertNull($group->id, 'Unsaved group has an id');
	}
	
	/**
	 * Test group create when no inputs are set
	 */
	public function testCreateGroupNoName() {

		$name = null;
		$slug = StringUtils::createRandomString(10);
		
		$group = new Group;
	    $group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,	    
	    ));
	    $this->assertFalse($group->save(), 'invalid group was saved');
	    $this->assertNull($group->id, 'Unsaved group has an id');
	}
	
	/**
	 * Test group create when no inputs are set
	 */
	public function testCreateGroupNoSlug() {

		$name = StringUtils::createRandomString(10);
		$slug = null;
		
		$group = new Group;
	    $group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,	    
	    ));
	    $this->assertFalse($group->save(), 'invalid group was saved');
	    $this->assertNull($group->id, 'Unsaved group has an id');
	}
}