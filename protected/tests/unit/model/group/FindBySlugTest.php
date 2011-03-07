<?php

require_once 'TestConstants.php';

class FindBySlugTest extends DbTestCase
{
	public $group;
	
	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
	}
    
	protected function setUp()
	{
		parent::setUp();
		
		$name = StringUtils::createRandomString(10);
		$slug = StringUtils::createRandomString(10);
		
		$this->group = new Group;
	    $this->group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    $this->group->save();
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
    	$foundGroup = Group::model()->findBySlug($this->group->slug);
    	
    	$this->assertTrue($foundGroup instanceof Group, 'found group not a Group object');
	    
	    $this->assertEquals($this->group->name, $foundGroup->name, 'found group name does not match saved group name');
	    $this->assertEquals($this->group->slug, $foundGroup->slug, 'found group slug does not match saved group slug');
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