<?php

require_once 'TestConstants.php';

class GroupRulesTest extends DbTestCase
{
	public $fixtures = array(
        'groups'=>'Group',
    );
    
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
     * Test name required rule 
     */
    public function testNameRequired_NullName() {		
	    $this->groupUnderTest->name = null;
	    $this->assertFalse($this->groupUnderTest->validate(), 
	    	"Group without name was validated");
    }

    /**
     * Test name required rule 
     */
    public function testNameRequired_BlankName() {		
	    $this->groupUnderTest->name = "";
	    $this->assertFalse($this->groupUnderTest->validate(), 
	    	"Group without name was validated");
    }
    
    /**
     * Test slug required rule 
     */
	public function testSlugRequired_NullSlug() {		
	    $this->groupUnderTest->slug = null;
	    $this->assertFalse($this->groupUnderTest->validate(), 
	    	"Group without slug was validated");
    }
    
    /**
     * Test slug required rule 
     */
	public function testSlugRequired_BlankSlug() {		
	    $this->groupUnderTest->slug = "";
	    $this->assertFalse($this->groupUnderTest->validate(), 
	    	"Group without slug was validated");
    }
    
	/**
     * Test name length rule 
     */
	public function testNameMaxLength() {		
	    $this->groupUnderTest->name = StringUtils::createRandomString(255);
	    $this->assertTrue($this->groupUnderTest->validate(), 
	    	"Group with name at max-length was not validated");
    }
    
	/**
     * Test name length rule 
     */
	public function testNameMaxLength_ExceedLength() {		
	    $this->groupUnderTest->name = StringUtils::createRandomString(255 + 1);
	    $this->assertFalse($this->groupUnderTest->validate(), 
	    	"Group with name over max-length was validated");
    }

	/**
     * Test slug length rule 
     */
	public function testSlugMaxLength() {		
	    $this->groupUnderTest->slug = StringUtils::createRandomString(50);
	    $this->assertTrue($this->groupUnderTest->validate(), 
	    	"Group with slug at max-length was not validated");
    }
    
	/**
     * Test slug length rule 
     */
	public function testSlugMaxLength_ExceedLength() {		
	    $this->groupUnderTest->slug = StringUtils::createRandomString(50 + 1);
	    $this->assertFalse($this->groupUnderTest->validate(), 
	    	"Group with slug over max-length was validated");
    }

    /**
     * Test name trim filter 
     */
	public function testNameTrim() {
		$name = StringUtils::createRandomString(10);
	    // add a name with extra whitespace
		$this->groupUnderTest->name = " " . $name . " ";
	    $this->groupUnderTest->validate();
	    $this->assertEquals(trim($name), $this->groupUnderTest->name, 
	    	"Group name was not trimmed");
    }
    
	/**
     * Test slug trim filter 
     */
	public function testSlugTrim() {
		$slug = StringUtils::createRandomString(10);
	    // add a slug with extra whitespace
		$this->groupUnderTest->slug = " " . $slug . " ";
	    $this->groupUnderTest->validate();
	    // must do more complex case-insensitive compare due to lower case filter 
	    $this->assertTrue(strcasecmp(trim($slug), $this->groupUnderTest->slug) == 0, 
	    	"Group slug was not trimmed");
	}
	
	/**
	 * Test name unique filter 
	 */
	public function testNameUnique() {
		// save the valid group so there is something to test against
		$this->groupUnderTest->save();
		
		$duplicateGroup = new Group();
		$duplicateGroup->name = $this->groupUnderTest->name;
		$duplicateGroup->slug = StringUtils::createRandomString(10);
		$this->assertFalse($duplicateGroup->validate(), 
	    	"Group without duplicated name was validated");
	}
	
	/**
	 * Test name unique filter 
	 */
	public function testSlugUnique() {
		// save the valid group so there is something to test against
		$this->groupUnderTest->save();
		
		$duplicateGroup = new Group();
		$duplicateGroup->name = StringUtils::createRandomString(10);
		$duplicateGroup->slug = $this->groupUnderTest->slug;
		$this->assertFalse($duplicateGroup->validate(), 
	    	"Group without duplicated slug was validated");
	}
	
	/**
	 * Test name unique filter 
	 */
	public function testSlugToLowerCase() {
		$slug = StringUtils::createRandomString(10);
	    // add a slug with extra whitespace
		$this->groupUnderTest->slug = " " . $slug . " ";
	    $this->groupUnderTest->validate();
	    $this->assertEquals(strtolower($slug), $this->groupUnderTest->slug, 
	    	"Group slug was not converted to lowercase");
	}
	
	/**
	 * Test safe filters
	 */
	public function testSafeAttributes() {
		$attribute = StringUtils::createRandomString(10);
		
		$this->groupUnderTest = new Group();
	    $this->groupUnderTest->setAttributes(array(
	    	'id' => $attribute,
	    	'name' => $attribute,
	    	'slug' => $attribute,
	    	'created' => $attribute,
	    	'modified' => $attribute,
	    ));
	    
	    $this->assertNull($this->groupUnderTest->id, 
	    	"Group id was set via set attributes");
	    $this->assertNotNull($this->groupUnderTest->name, 
	    	"Group name was not set via set attributes");
	    $this->assertNotNull($this->groupUnderTest->slug, 
	    	"Group slug was not set via set attributes");
	    $this->assertNull($this->groupUnderTest->created, 
	    	"Group created was set via set attributes");
	    $this->assertNull($this->groupUnderTest->modified, 
	    	"Group modified was set via set attributes");
	}
}