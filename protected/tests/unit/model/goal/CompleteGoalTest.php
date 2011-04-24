<?php

require_once 'TestConstants.php';

class CompleteGoalTest extends DbTestCase
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
	public function testCompleteNewGoal() {
		$goal = new Goal();
		
		try {
			// complete goal
			$goal->complete();
		}
		catch(Exception $e) {
			$this->fail('Goal->complete() threw exception: ' . $e->getMessage());
		}
		
		if($goal->isCompleted) {
			// test passes
		}
		else {
			$this->fail('complete call did not update isComplete value');
		}
	}
	
	/**
	 * Create a valid goal
	 */
	public function testUnCompleteNewGoal() {
		$goal = new Goal();
		
		try {
			// complete goal
			$goal->uncomplete();
		}
		catch(Exception $e) {
			$this->fail('Goal->uncomplete() threw exception: ' . $e->getMessage());
		}
		
		if($goal->isCompleted) {
			$this->fail('uncomplete call did not update isComplete value');
		}
		else {
			// test passes
		}
	}
}
