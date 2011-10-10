<?php

require_once 'TestConstants.php';

class FindBySlugTest extends DbTestCase
{
	var $group;
	var $groupName;
	var $groupSlug;
	
	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
	}
    
	protected function setUp()
	{
		parent::setUp();
		
		$this->groupName = StringUtils::createRandomString(10);
		$this->groupSlug = StringUtils::createRandomString(10);
		
	    $this->group = GroupFactory::insert(
	    	array(
	        	'name' => $this->groupName,
	        	'slug' => $this->groupSlug,
	    	)
	    );
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
	 * Test using the correct slug
	 */
    public function testFindByGroupValid() {
    	$foundGroup = Group::model()->findBySlug($this->groupSlug);
    	
    	$this->assertTrue($foundGroup instanceof Group, 'found group not a Group object');
	    
	    $this->assertEquals($this->groupName, $foundGroup->name, 'found group name does not match saved group name');
	    $this->assertEquals($this->groupSlug, $foundGroup->slug, 'found group slug does not match saved group slug');
	}
	
	/**
	 * Test using an incorrect slug
	 */
    public function testFindByGroupInvalid() {
    	$foundGroup = Group::model()->findBySlug(StringUtils::createRandomString(10));
    	
    	$this->assertNull($foundGroup, 'found a group based on a fake slug');
	}
	
	/**
	 * Test using a null slug
	 */
    public function testFindByGroupNull() {
    	$foundGroup = Group::model()->findBySlug(null);
    	
    	$this->assertNull($foundGroup, 'found a group based on a null slug');
    }
}