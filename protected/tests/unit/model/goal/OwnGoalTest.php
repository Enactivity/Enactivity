<?php

require_once 'TestConstants.php';

class OwnGoalTest extends DbTestCase
{

	public $fixtures = array(
		'groupFixtures'=>':group',
		'userFixtures'=>':user',
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
	public function testOwnNewGoal() {
		$goal = new Goal();
		
		try {
			// own goal
			$goal->own();
		}
		catch(Exception $e) {
			$this->fail('Goal->own() threw exception: ' . $e->getMessage());
		}
		
		$this->assertNotNull(
			$goal->ownerId, 
			"Goal's owner id is null after own call"
		);
		$this->assertEquals(
			Yii::app()->user->id,
			$goal->ownerId, 
			"Owning the goal did not set the goal's owner id to current user"
		);
	}
	
	/**
	 * Create a valid goal
	 */
	public function testUnOwnNewGoal() {
		$goal = new Goal();
		
		try {
			// own goal
			$goal->unown();
		}
		catch(Exception $e) {
			$this->fail('Goal->unown() threw exception: ' . $e->getMessage());
		}
		
		$this->assertNull(
			$goal->ownerId, 
			"Goal's owner id is not null after unown call"
		);
		$this->assertNotEquals(
			Yii::app()->user->id,
			$goal->ownerId,
			"Owner id matches current user after unown call"
		);
	}
}