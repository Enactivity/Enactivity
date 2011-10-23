<?php

require_once 'TestConstants.php';

class GroupGetPermalinkTest extends DbTestCase
{
	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
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
	 * Test that the permalink is valid with a character string 
	 */
    public function testGetPermalinkValid() {
    	$group = new Group;
    	$group->slug = 'ponclateststring';
	    
    	$permalink = $group->getPermalink();
    	
    	$calculatedLink = Yii::app()->request->hostInfo .
			Yii::app()->getBaseUrl() .
			'/ponclateststring';
    	
    	$this->assertEquals($calculatedLink, $permalink, 'Get permalink did not match expected link');
    }
    
	/**
	 * Test that the permalink is valid when the group has no slug 
	 */
    public function testGetPermalinkNull() {
    	$group = new Group;
    	$group->id = '42';
    	$group->slug = null;
	    
    	$permalink = $group->getPermalink();
    	
    	$calculatedLink = Yii::app()->request->hostInfo .
			Yii::app()->createUrl('group/view', 
			array(
            	'id'=> $group->id,
			)
		);
    	
    	$this->assertEquals($calculatedLink, $permalink, 'Get permalink did not match expected link');
    }
    
	/**
	 * Test that the permalink is valid when the group has no slug 
	 */
    public function testGetPermalinkBlank() {
    	$group = new Group;
    	$group->id = '42';
    	$group->slug = '';
	    
    	$permalink = $group->getPermalink();
    	
		$calculatedLink = Yii::app()->request->hostInfo .
			Yii::app()->createUrl('group/view', 
			array(
				'id'=> $group->id,
			)
		);
		    	
		$this->assertEquals($calculatedLink, $permalink, 'Get permalink did not match expected link');
    }
}