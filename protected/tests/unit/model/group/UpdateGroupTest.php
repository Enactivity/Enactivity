<?php

require_once 'TestConstants.php';

class UpdateGroupTest extends DbTestCase
{
	public $group;
	
	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
	}
    
	protected function setUp()
	{
		parent::setUp();
		$this->group = new Group;
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
    public function testUpdateGroupValid() {
    	
		$name = StringUtils::createRandomString(10);
		$slug = StringUtils::createRandomString(10);
		
	    $this->group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    $this->assertTrue($this->group->save(), 'valid group was not saved: ' . CVarDumper::dumpAsString($this->group->getErrors()));
	    $this->assertNotNull($this->group->id, 'save did not set group id');
	    
	    // verify the group can be found in db 
	    $this->group = Group::model()->findByPk($this->group->id);
	    
	    $this->assertTrue($this->group instanceof Group, 'found group not a Group object');
	    
	    $this->assertEquals($name, $this->group->name, 'group name was not saved');
	    $this->assertEquals(strtolower($slug), $this->group->slug, 'group slug was not saved');
	    
	    $this->assertNotNull($this->group->created, 'group created was not set');
	    $this->assertNotNull($this->group->modified, 'group modified was not set');
	}
	
	/**
	 * Create a valid group and ensure entries are trimmed
	 */
    public function testUpdateGroupTrimSpaces() {
    	
		$name = StringUtils::createRandomString(10);
		$slug = StringUtils::createRandomString(10);
		
		$paddedName = ' ' . $name . ' ';
		$paddedSlug = ' ' . $slug . ' ';
		
	    $this->group->setAttributes(array(
	        'name' => $paddedName,
	        'slug' => $paddedSlug,
	    ));
	    
	    $this->assertTrue($this->group->save(), 'valid group was not saved: ' . CVarDumper::dumpAsString($this->group->getErrors()));
	    $this->assertNotNull($this->group->id, 'save did not set group id');
	    
	    // verify the group can be found in db 
	    $this->group = Group::model()->findByPk($this->group->id);
	    
	    $this->assertTrue($this->group instanceof Group, 'found group not a Group object');
	    
	    $this->assertEquals($name, $this->group->name, 'name was not trimmed');
	    $this->assertEquals(strtolower($slug), $this->group->slug, 'slug was not trimmed');
	    
	    $this->assertNotNull($this->group->created, 'group created was not set');
	    $this->assertNotNull($this->group->modified, 'group modified was not set');
	}
	
	/**
	 * Create a valid group
	 */
    public function testUpdateGroupMaximumInputs() {
    	
		$name = StringUtils::createRandomString(255);
		$slug = StringUtils::createRandomString(50);
		
	    $this->group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    $this->assertTrue($this->group->save(), 'valid group was not saved: ' . CVarDumper::dumpAsString($this->group->getErrors()));
	 
	    $this->assertNotNull($this->group->id, 'save did not set group id');
	    
	    // verify the group can be found in db 
	    $this->group = Group::model()->findByPk($this->group->id);
	    
	    $this->assertTrue($this->group instanceof Group, 'found group not a Group object');
		
	    $this->assertEquals($name, $this->group->name, 'group name was not saved');
	    $this->assertEquals(strtolower($slug), $this->group->slug, 'group slug was not saved');
	    
	    $this->assertNotNull($this->group->created, 'group created was not set');
	    $this->assertNotNull($this->group->modified, 'group modified was not set');
	}
	
	/**
	 * Set inputs over the acceptable lengths
	 */
    public function testUpdateGroupNameExceedsMaximumInputs() {
    	
		$name = StringUtils::createRandomString(255 + 1);
		
	    $this->group->setAttributes(array(
	        'name' => $name,
	    ));
	    $this->assertFalse($this->group->save(), 'invalid group was saved');
	}

	/**
	 * Set inputs over the acceptable lengths
	 */
    public function testUpdateGroupSlugExceedsMaximumInputs() {
    	
		$slug = StringUtils::createRandomString(50 + 1);
		
	    $this->group->setAttributes(array(
	        'slug' => $slug,
	    ));
	    $this->assertFalse($this->group->save(), 'invalid group was saved');
	}
	
	
	/**
	 * Test group create when name and slug are blank
	 */
	public function testUpdateGroupBlankInputs() {

		$name = '';
		$slug = '';
		
	    $this->group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    
	    $this->assertFalse($this->group->save(), 'invalid group was saved');
	}
	
	/**
	 * Test group create when no inputs are set
	 */
	public function testUpdateGroupNullInputs() {

		$name = null;
		$slug = null;
		
	    $this->group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,	    
	    ));
	    $this->assertFalse($this->group->save(), 'invalid group was saved');
	}
	
	/**
	 * Test group create when no inputs are set
	 */
	public function testUpdateGroupNoName() {

		$name = null;
		$slug = StringUtils::createRandomString(10);
		
	    $this->group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,	    
	    ));
	    $this->assertFalse($this->group->save(), 'invalid group was saved');
	}
	
	/**
	 * Test group create when no inputs are set
	 */
	public function testUpdateGroupNoSlug() {

		$name = StringUtils::createRandomString(10);
		$slug = null;
		
	    $this->group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,	    
	    ));
	    $this->assertFalse($this->group->save(), 'invalid group was saved');
	}
	
	/**
	 * Test that groups with duplicate names cannot be saved
	 */
	public function testUpdateGroupDuplicateName() {

		$name = GroupFactory::insert()->name;
		$slug = null;
		
	    $this->group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,	    
	    ));
	    
	    $this->assertFalse($this->group->validate(), 'group with duplicate name was marked valid');
	    $this->assertFalse($this->group->save(), 'group with duplicate name was saved');
	}
}