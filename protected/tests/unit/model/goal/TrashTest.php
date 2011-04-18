<?php

require_once 'TestConstants.php';

class TrashTest extends DbTestCase
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
	public function testTrashNewGoal() {
		$goal = new Goal();
		$goal->trash();
		
		if($goal->isTrash) {
			// test passes
		}
		else {
			$this->fail('trash call did not update isTrash value');
		}
	}
	
	/**
	 * Create a valid goal
	 */
	public function testUnTrashNewGoal() {
		$goal = new Goal();
		$goal->untrash();
		
		if($goal->isTrash) {
			$this->fail('untrash call did not update isTrash value');
		}
		else {
			// test passes
		}
	}
}