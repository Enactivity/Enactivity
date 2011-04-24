<?php

require_once 'TestConstants.php';

class OwnTaskTest extends DbTestCase
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
	public function testOwnNewTask() {
		$task = new Task();
		
		try {
			// own task
			$task->own();
		}
		catch(Exception $e) {
			$this->fail('Task->own() threw exception: ' . $e->getMessage());
		}
		
		$this->assertNotNull(
			$task->ownerId, 
			"Task's owner id is null after own call"
		);
		$this->assertEquals(
			Yii::app()->user->id,
			$task->ownerId, 
			"Owning the task did not set the task's owner id to current user"
		);
	}
	
	/**
	 * Create a valid task
	 */
	public function testUnOwnNewTask() {
		$task = new Task();
		
		try {
			// own task
			$task->unown();
		}
		catch(Exception $e) {
			$this->fail('Task->unown() threw exception: ' . $e->getMessage());
		}
		
		$this->assertNull(
			$task->ownerId, 
			"Task's owner id is not null after unown call"
		);
		$this->assertNotEquals(
			Yii::app()->user->id,
			$task->ownerId,
			"Owner id matches current user after unown call"
		);
	}
}