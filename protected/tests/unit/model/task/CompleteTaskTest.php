<?php

require_once 'TestConstants.php';

class CompleteTaskTest extends DbTestCase
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
	 * Create a valid task
	 */
	public function testCompleteNewTask() {
		$task = new Task();
		
		try {
			// complete task
			$task->complete();
		}
		catch(Exception $e) {
			$this->fail('Task->complete() threw exception: ' . $e->getMessage());
		}
		
		if($task->isCompleted) {
			// test passes
		}
		else {
			$this->fail('complete call did not update isComplete value');
		}
	}
	
	/**
	 * Create a valid task
	 */
	public function testUnCompleteNewTask() {
		$task = new Task();
		
		try {
			// complete task
			$task->uncomplete();
		}
		catch(Exception $e) {
			$this->fail('Task->uncomplete() threw exception: ' . $e->getMessage());
		}
		
		if($task->isCompleted) {
			$this->fail('uncomplete call did not update isComplete value');
		}
		else {
			// test passes
		}
	}
}
