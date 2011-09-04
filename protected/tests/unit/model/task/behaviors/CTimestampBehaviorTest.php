<?php
/**
 * Tests related to the CTimestampBehavior of a Task model
 * @author ajsharma
 */
class CTimestampBehaviorTest extends DbTestCase {

	var $task;

	public function setUp() {
		parent::setUp();

		// test parameters
		$name = "test task";
		$isTrash = 0;
		$created = date ("Y-m-d H:i:s", strtotime("-1 hours"));
		$modified = date ("Y-m-d H:i:s", strtotime("-1 hours"));

		// run test
		$this->task = new Task();
		$this->task->attributes = array(
			'name' => $name,
			'isTrash' => $isTrash,
			'created' => $created,
			'modified' => $modified,
		);
	}

	/**
	 * Test that created timestamp is set
	 */
	public function testCreatedSetOnInsert() {

		// confirm datetimes are not set
		$this->assertNull($this->task->created, 'task created attribute was assigned in [' . $this->task->getScenario() . ']');

		$this->task->saveNode();

		// confirm datetime set
		$this->assertNotNull($this->task->created, 'task created attribute was not assigned in [' . $this->task->getScenario() . ']');
	}
	
	/**
	 * Test that created is set to current time
	 */
	public function testCreatedSetCorrectly() {
		$now = time();
		
		$this->task->saveNode();
		
		$later = time();
		
		$task = Task::model()->findByPk($this->task->id);
		$created = strtotime($task->created);
		
		$this->assertGreaterThanOrEqual($now, $created, "Task created is earlier than save time");
		$this->assertLessThanOrEqual($later, $created, "Task created is later than save time");
	}

	/**
	 * Test that modified timestamp is set
	 */
	public function testModifiedSetOnInsert() {

		// confirm datetimes are not set
		$this->assertNull($this->task->modified, 'task modified attribute was assigned in [' . $this->task->getScenario() . ']');

		$this->task->saveNode();

		// confirm datetime set
		$this->assertNotNull($this->task->modified, 'task modified attribute was not assigned in [' . $this->task->getScenario() . ']');
	}

	/**
	 * Test that modified timestamp is set on update
	 */
	public function testModifiedSetOnUpdate() {

		// insert task
		$this->task->saveNode();
		
		// find task
		$oldTask = Task::model()->findByPk($this->task->id);

		// update task
		$oldTask->name = "test task updated";
		$oldTask->saveNode();

		// find task again
		$newTask = Task::model()->findByPk($this->task->id);
		
		// confirm datetime set
		$this->assertNotEquals($oldTask->modified, $newTask->modified, "task modified attribute was not updated on update");
	}

}