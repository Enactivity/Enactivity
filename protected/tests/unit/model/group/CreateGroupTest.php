<?php

require_once 'TestConstants.php';

class CreateGroupTest extends DbTestCase
{
    public $groupUnderTest = null;

	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
	}
    
	protected function setUp()
	{
		parent::setUp();
		
		// create a valid group
		$name = StringUtils::createRandomString(10);
		$slug = StringUtils::createRandomString(10);
		
		$this->groupUnderTest = new Group();
	    $this->groupUnderTest->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
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
    public function testCreateGroupValidSave() {
    	
		$name = StringUtils::createRandomString(10);
		$slug = StringUtils::createRandomString(10);
		
		$this->groupUnderTest = new Group();
	    $this->groupUnderTest->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    $this->assertTrue($this->groupUnderTest->save(), 'valid group was not saved');
	    $this->assertNotNull($this->groupUnderTest->id, 'save did not set group id');
	    
	    // verify the group can be found in db 
	    $foundGroup = Group::model()->findByPk($this->groupUnderTest->id);
	    
	    $this->assertTrue($foundGroup instanceof Group, 'found group not a Group object');
	    
	    $this->assertEquals($name, $foundGroup->name, 'group name was not saved');
	    $this->assertEquals(strtolower($slug), $foundGroup->slug, 'group slug was not saved');
	    
	    $this->assertNotNull($foundGroup->created, 'group created was not set');
	    $this->assertNotNull($foundGroup->modified, 'group modified was not set');
	}
	
	/**
	 * Create a valid group and ensure entries are trimmed
	 */
    public function testCreateGroupTrimSpaces() {
    	
		$name = StringUtils::createRandomString(10);
		$slug = StringUtils::createRandomString(10);
		
		$paddedName = ' ' . $name . ' ';
		$paddedSlug = ' ' . $slug . ' ';
		
		$this->groupUnderTest = new Group();
	    $this->groupUnderTest->setAttributes(array(
	        'name' => $paddedName,
	        'slug' => $paddedSlug,
	    ));
	    
	    $this->assertTrue($this->groupUnderTest->save(), 'valid group was not saved');
	    $this->assertNotNull($this->groupUnderTest->id, 'save did not set group id');
	    
	    // verify the group can be found in db 
	    $foundGroup = Group::model()->findByPk($this->groupUnderTest->id);
	    
	    $this->assertTrue($foundGroup instanceof Group, 'found group not a Group object');
	    
	    $this->assertEquals($name, $foundGroup->name, 'name was not trimmed');
	    $this->assertEquals(strtolower($slug), $foundGroup->slug, 'slug was not trimmed');
	    
	    $this->assertNotNull($foundGroup->created, 'group created was not set');
	    $this->assertNotNull($foundGroup->modified, 'group modified was not set');
	}
	
	/**
	 * Create a valid group
	 */
    public function testCreateGroupMaximumInputs() {
    	
		$name = StringUtils::createRandomString(255);
		$slug = StringUtils::createRandomString(50);
		
		$this->groupUnderTest = new Group();
	    $this->groupUnderTest->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    $this->assertTrue($this->groupUnderTest->save(), 'valid group was not saved');
	 
	    $this->assertNotNull($this->groupUnderTest->id, 'save did not set group id');
	    
	    // verify the group can be found in db 
	    $foundGroup = Group::model()->findByPk($this->groupUnderTest->id);
	    
	    $this->assertTrue($foundGroup instanceof Group, 'found group not a Group object');
		
	    $this->assertEquals($name, $foundGroup->name, 'group name was not saved');
	    $this->assertEquals(strtolower($slug), $foundGroup->slug, 'group slug was not saved');
	    
	    $this->assertNotNull($foundGroup->created, 'group created was not set');
	    $this->assertNotNull($foundGroup->modified, 'group modified was not set');
	}
	
	/**
	 * Set inputs over the acceptable lengths
	 */
    public function testCreateGroupExceedMaximumInputs() {
    	
		$name = StringUtils::createRandomString(255 + 1);
		$slug = StringUtils::createRandomString(50 + 1);
		
		$this->groupUnderTest = new Group();
	    $this->groupUnderTest->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    $this->assertFalse($this->groupUnderTest->save(), 'invalid group was saved');
	    $this->assertNull($this->groupUnderTest->id, 'Unsaved group has an id');
	}
	
	/**
	 * Test group create when name and slug are blank
	 */
	public function testCreateGroupBlankInputs() {

		$name = '';
		$slug = '';
		
		$this->groupUnderTest = new Group();
	    $this->groupUnderTest->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    
	    $this->assertFalse($this->groupUnderTest->save(), 'invalid group was saved');
	    $this->assertNull($this->groupUnderTest->id, 'Unsaved group has an id');
	}
	
	/**
	 * Test group create when no inputs are set
	 */
	public function testCreateGroupNullInputs() {

		$name = null;
		$slug = null;
		
		$this->groupUnderTest = new Group();
	    $this->groupUnderTest->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,	    
	    ));
	    $this->assertFalse($this->groupUnderTest->save(), 'invalid group was saved');
	    $this->assertNull($this->groupUnderTest->id, 'Unsaved group has an id');
	}
	
	/**
	 * Test group create when no inputs are set
	 */
	public function testCreateGroupNoInputs() {

		$this->groupUnderTest = new Group();
	    $this->groupUnderTest->setAttributes(array());
	    $this->assertFalse($this->groupUnderTest->save(), 'invalid group was saved');
	    $this->assertNull($this->groupUnderTest->id, 'Unsaved group has an id');
	}
	
	/**
	 * Test group create when no inputs are set
	 */
	public function testCreateGroupNoName() {

		$name = null;
		$slug = StringUtils::createRandomString(10);
		
		$this->groupUnderTest = new Group();
	    $this->groupUnderTest->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,	    
	    ));
	    $this->assertFalse($this->groupUnderTest->save(), 'invalid group was saved');
	    $this->assertNull($this->groupUnderTest->id, 'Unsaved group has an id');
	}
	
	/**
	 * Test group create when no inputs are set
	 */
	public function testCreateGroupNoSlug() {

		$name = StringUtils::createRandomString(10);
		$slug = null;
		
		$this->groupUnderTest = new Group();
	    $this->groupUnderTest->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,	    
	    ));
	    $this->assertFalse($this->groupUnderTest->save(), 'invalid group was saved');
	    $this->assertNull($this->groupUnderTest->id, 'unsaved group has an id');
	}
	
	/**
	 * Test that groups with duplicate names cannot be saved
	 */
	public function testUpdateGroupDuplicateName() {

		$name = $this->groupFixtures['testgroup']['name'];
		$slug = null;
		
		$this->groupUnderTest = new Group();
	    $this->groupUnderTest->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,	    
	    ));
	    
	    $this->assertFalse($this->groupUnderTest->validate(), 'group with duplicate name was marked valid');
	    $this->assertFalse($this->groupUnderTest->save(), 'group with duplicate name was saved');
	}
}