<?php
/**
 * Tests related to the initial insertion of a Task model
 * @author ajsharma
 */
class InsertTaskTest extends DbTestCase
{
	public function setUp() {
		parent::setUp();
	}

	/**
	 * Insert a valid task
	 */
	public function testInsertTaskValidScenarioDefault() {

		// test parameters
		$id = 42;
		$name = "test task";
		$isTrash = 0;
		$created = date ("Y-m-d H:i:s", strtotime("-1 hours"));
		$modified = date ("Y-m-d H:i:s", strtotime("-1 hours"));

		// run test
		$task = new Task();

		$this->assertEquals(Task::SCENARIO_INSERT, $task->scenario, "Task's default scenario is not " . Task::SCENARIO_INSERT);

		$task->attributes = array(
			'id' => $id,
			'name' => $name,
			'isTrash' => $isTrash,
			'created' => $created,
			'modified' => $modified,
		);

		// confirm attribute assigned properly
		$this->assertNull($task->id, 'task id attribute was assigned in [' . $task->getScenario() . ']');
		$this->assertNotNull($task->name, 'task name attribute was not assigned in [' . $task->getScenario() . ']');
		$this->assertNotNull($task->isTrash, 'task isTrash attribute was not assigned in [' . $task->getScenario() . ']');
		
		// confirm datetimes are set
		$this->assertNull($task->created, 'task created attribute was assigned in [' . $task->getScenario() . ']');
		$this->assertNull($task->modified, 'task modified attribute was assigned in [' . $task->getScenario() . ']');

		// confirm validation & save works
		$this->assertTrue($task->validate(), 'valid task was not validated: ' . print_r($task->getErrors(null), true));
		$this->assertTrue($task->saveNode(), 'valid task was not saved');
	}

	/**
	 * Insert a valid task and test if name is null
	 */
	public function testInsertTaskWithNullName() {

		$name = null;

		$task = new Task();
		$task->setAttributes(array(
			'name' => $name,
		));

		$this->assertNull($task->name, 'save name is not null');
		$this->assertFalse($task->validate(), 'task without name was validated: ' . print_r($task->getErrors(null), true));
		$this->assertFalse($task->saveNode(), 'task without name was saved: ' . print_r($task->getErrors(null), true));
	}

	/**
	 * Insert a valid task and ensure entries are trimmed
	 */
	public function testInsertTaskTrimSpaces() {

		$name = "Test Task";
		$paddedName = ' ' . $name . ' ';

		$task = new Task();
		$task->setAttributes(array(
			'name' => $paddedName,
		));

		$this->assertTrue($task->saveNode(), 'valid task was not saved: ' . print_r($task->getErrors(null), true));

		$this->assertNotNull($task->created, 'task created was not set');
		$this->assertNotNull($task->modified, 'task modified was not set');
	}

	/**
	 * Set name input over the acceptable lengths
	 */
	public function testInsertTaskExceedMaximumNameInput() {

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
	public function testInsertTaskNoInput() {

		$name = null;

		$task = new Task();
		$task->setAttributes(array(
			'name' => $name,
		));

		$this->assertNull($task->name, 'unsaved task has a name');
		$this->assertFalse($task->validate(), 'task with no inputs was validated');
		$this->assertFalse($task->saveNode(), 'task with no inputs was saved');
	}
	
	/**
	* Test task create when only a name
	*/
	public function testInsertTaskNameOnly() {
	
		$name = StringUtils::createRandomString(16);
	
		$task = new Task();
		$task->setAttributes(array(
				'name' => $name,
		));
	
		$this->assertNotNull($task->name, 'unsaved task has no name');
		$this->assertNull($task->starts, 'unsaved task has no name');
		
		$this->assertTrue($task->validate(), 'valid task was not validated: ' . print_r($task->getErrors(null), true));
		$this->assertTrue($task->saveNode(), 'valid task was not saved');
	}

}