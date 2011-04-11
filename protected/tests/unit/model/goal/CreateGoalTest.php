<?php

require_once 'TestConstants.php';

class CreateGoalTest extends DbTestCase
{

	public $group;
	
	public $fixtures = array(
		'groupFixtures'=>'Group',
		'userFixtures'=>'User',
		'groupUserFixtures'=>':group_user',
	);
			
	public function setUp()
	{
		parent::setUp();
		
		// login as user
		$loginForm = new UserLoginForm();
		$loginForm->email = $this->userFixtures['registered']['email'];
		$loginForm->password = 'test';
		$loginForm->login();
	}
	
	/**
	 * Create a valid goal
	 */
	public function testCreateGoalValid() {
		
		$goal = new Goal();
		$goal->setAttributes(array(
	    	'name' => "Test Goal",
			'groupId' => $this->groupFixtures['testgroup']->id,
	    ));
	    
	    $this->assertTrue($goal->validate(), 'valid goal was not validated');
	    $this->assertTrue($goal->save(), 'valid goal was not saved');
	}
	
	/**
	 * Create a valid goal and test if name is null
	 */
	public function testCreateGoalWithNullName() {
		
		$name = null;
		$goal = new Goal();
		$goal->setAttributes(array(
	    	'name' => $name,
			'groupId' => $this->groupFixtures['testgroup']->id,
	    ));
	    
	   $this->assertNull($goal->name, 'save name is not null');
	   $this->assertFalse($goal->validate(), 'goal without name was validated');
	}
	
	/**
	 * Create a valid goal and ensure entries are trimmed
	 */
	public function testCreateGoalTrimSpaces() {
		$name = "Test Goal";
		$paddedName = ' ' . $name . ' ';
		$goal = new Goal();
		$goal->setAttributes(array(
	    	'name' => $paddedName,
			'groupId' => $this->groupFixtures['testgroup']->id,
	    ));
	    
	   $this->assertTrue($goal instanceof Goal, 'found goal not a Goal object');
	   $this->assertTrue($goal->save(), 'valid goal was not saved');
	   $this->assertNotNull($goal->created, 'goal created was not set');
	   $this->assertNotNull($goal->modified, 'goal modified was not set');
			
	}
	
	/**
	 * Set name input over the acceptable lengths
	 */
    public function testCreateGoalExceedMaximumNameInput() {
    	
		$name = StringUtils::createRandomString(255 + 1);

		$goal = new Goal();
		$goal->setAttributes(array(
	    	'name' => $name,
			'groupId' => $this->groupFixtures['testgroup']->id,
	    ));
		
	    $this->assertFalse($goal->validate(), 'goal with name of 256 characters was validated');
	    $this->assertFalse($goal->save(), 'goal with name of 256 characters was saved');
	}
	
	/**
	 * Test goal create when no name, starts and ends are set
	 */
	public function testCreateGoalNoInput() {

		$name = null;
		$groupId = null;
		
		$goal = new Goal();
		$goal->setAttributes(array(
	    	'name' => $name,
			'groupId' => $groupId,
	    ));
	    
	    $this->assertNull($goal->name, 'unsaved goal has a name');
	    $this->assertNull($goal->groupId, 'unsaved goal has a groupid');
	    $this->assertFalse($goal->validate(), 'goal with no inputs was saved');
	}

	/**
	 * Test goal create when no groupid is set
	 */
	public function testCreateGoalNoGroupID() {

		$name = "Test Name";
		$groupId = null;
		
		$goal = new Goal();
		$goal->setAttributes(array(
	    	'name' => $name,
			'groupId' => $groupId,
	    ));
	    
	    $this->assertNull($goal->groupId, 'unsaved goal has a groupid');
	    $this->assertTrue($goal->validate(), 'goal groupId was not automatically set');
	}
}
