<?php

require_once 'TestConstants.php';

class CompleteTest extends DbTestCase
{

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
	public function testCompleteNewGoal() {
		$goal = new Goal();
		$goal->complete();
		
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
		$goal->uncomplete();
		
		if($goal->isCompleted) {
			$this->fail('uncomplete call did not update isComplete value');
		}
		else {
			// test passes
		}
	}
}
