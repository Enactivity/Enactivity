<?php

require_once 'TestConstants.php';

class CreateTaskTest extends DbTestCase
{
	public function setUp() {
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
	public function testCreateTaskValidScenarioDefault() {
		
		// test parameters
		$id = 42;
		$name = "test task";
		$isTrash = 0;
		$created = date ("Y-m-d H:i:s", strtotime("-1 hours"));
		$modified = date ("Y-m-d H:i:s", strtotime("-1 hours"));
		
		$testdata = array(
			'id' => $id,
			'name' => $name,
			'isTrash' => $isTrash,
			'created' => $created,
			'modified' => $modified,
		);
		
		// run test
		$task = new Task();
		
		$this->assertEquals(Task::SCENARIO_INSERT, $task->scenario, "Task's default scenario is not " . Task::SCENARIO_INSERT);
		
		$task->attributes = $testdata;
		
		// confirm attribute assigned properly
		$this->assertNull($task->id, 'task id attribute was assigned in [' . $task->getScenario() . ']');
		$this->assertNotNull($task->name, 'task name attribute was not assigned in [' . $task->getScenario() . ']');
		$this->assertNotNull($task->isTrash, 'task isTrash attribute was not assigned in [' . $task->getScenario() . ']');
		$this->assertNull($task->created, 'task created attribute was assigned in [' . $task->getScenario() . ']');
		$this->assertNull($task->modified, 'task modified attribute was assigned in [' . $task->getScenario() . ']');
		
		// confirm validation & save works
		$this->assertTrue($task->validate(), 'valid task was not validated: ' . print_r($task->getErrors(null), true));
		$this->assertTrue($task->saveNode(), 'valid task was not saved');
	}
	
	/**
	* Create a valid task and test if name is null
	*/
	public function testCreateTaskWithNullName() {
		
		$name = null;
		
		$task = new Task();
		$task->setAttributes(array(
			'name' => $name,
		));
		
		$this->assertNull($task->name, 'save name is not null');
		$this->assertFalse($task->validate(), 'task without name was validated: ' . print_r($task->getErrors(null), true));
	}
	
	/**
	* Create a valid task and ensure entries are trimmed
	*/
	public function testCreateTaskTrimSpaces() {
		
		$name = "Test Task";
		$paddedName = ' ' . $name . ' ';
		
		$task = new Task();
		$task->setAttributes(array(
			'name' => $paddedName,
		));
		
		$this->assertTrue($task instanceof Task, 'found task not a Task object');
		$this->assertTrue($task->saveNode(), 'valid task was not saved: ' . print_r($task->getErrors(null), true));
		$this->assertNotNull($task->created, 'task created was not set');
		$this->assertNotNull($task->modified, 'task modified was not set');
			
	}
	
	/**
	* Set name input over the acceptable lengths
	*/
	public function testCreateTaskExceedMaximumNameInput() {
		
		$name = StringUtils::createRandomString(255 + 1);

		$task = new Task();
		$task->setAttributes(array(
			'name' => $name,
		));
		
		$this->assertFalse($task->validate(), 'task with name of 256 characters was validated: ' . print_r($task->getErrors(null), true));
		$this->assertFalse($task->saveNode(), 'task with name of 256 characters was saved');
	}
	
	/**
	* Test task create when no name, starts and ends are set
	*/
	public function testCreateTaskNoInput() {

		$name = null;
		
		$task = new Task();
		$task->setAttributes(array(
			'name' => $name,
		));
		
		$this->assertNull($task->name, 'unsaved task has a name');
		$this->assertFalse($task->validate(), 'task with no inputs was saved');
	}
	
}