<?php

require_once 'TestConstants.php';

class TrashTaskTest extends DbTestCase
{
			
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
	public function testTrashNewTask() {
		$task = new Task();
		
		try {
			$task->trash();
		}
		catch(Exception $e) {
			$this->fail('Task->trash() threw exception: ' . $e->getMessage());
		}
		
		if($task->isTrash) {
			// test passes
		}
		else {
			$this->fail('trash call did not update isTrash value');
		}
	}
	
	/**
	 * Create a valid task
	 */
	public function testUnTrashNewTask() {
		$task = new Task();
		
		try {
			$task->untrash();
		}
		catch(Exception $e) {
			$this->fail('Task->untrash() threw exception: ' . $e->getMessage());
		}
		
		if($task->isTrash) {
			$this->fail('untrash call did not update isTrash value');
		}
		else {
			// test passes
		}
	}
}
