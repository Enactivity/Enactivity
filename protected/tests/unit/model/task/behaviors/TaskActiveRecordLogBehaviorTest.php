<?php
/**
 * Tests related to the CTimestampBehavior of a Task model
 * @author ajsharma
 */
class TaskActiveRecordLogBehavior extends DbTestCase {

	public function setUp() {
		parent::setUp();
	}

	const SCENARIO_DELETE = 'delete';
	const SCENARIO_INSERT = 'insert'; // default set by Yii
	const SCENARIO_TRASH = 'trash';
	const SCENARIO_UNTRASH = 'untrash';
	const SCENARIO_UPDATE = 'update'; // default set by Yii

	public function testScenarioDelete() {
		$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
	}

	/**
	 * Test the a new task has the inital feed item.
	 **/
	public function testScenarioInsertInitialFeed() {
		$task = TaskFactory::insert();
		$task->refresh();
		$feed = $task->feed;
		$this->assertEquals(1, count($feed), 'Task has more than one feed item on insert');
	}

	public function testScenarioInsertInitialFeedNameMatch() {
		$task = TaskFactory::insert();
		$task->refresh();
		$feed = $task->feed;
		$this->assertEquals(1, count($feed), 'Task has more than one feed item on insert');
	}


	public function testScenarioTrash() {
		$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
	}

	public function testScenarioUntrash() {
		$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
	}

	public function testScenarioUpdate() {
		$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
	}

}