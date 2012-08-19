<?php
/**
 * Tests related to the CTimestampBehavior of a Task model
 * @author ajsharma
 */
class TaskActiveRecordLogBehavior extends DbTestCase {

	public function setUp() {
		parent::setUp();
	}

	/**
	 * Test the a new task has the inital feed item.
	 **/
	public function testScenarioInsertInitialFeed() {
		$task = TaskFactory::insert();
		$feed = $task->feed;
		
		$this->assertEquals(1, count($feed), 'Task has more than one feed item on insert');
	}

	public function testScenarioInsertInitialFeedNameMatch() {
		$task = TaskFactory::insert();
		$feed = $task->feed;

		$lastFeedItem = array_pop($feed);

		$this->assertEquals($task->name, $lastFeedItem->focalModelName, "Task name does not match focalModelName in feed");
	}

	public function testScenarioUpdate() {
		$task = TaskFactory::insert();
		$feed = $task->feed;
		$feedInitialCount = count($feed);

		$task->updateTask(array(
			'name' => "ptask" . StringUtils::uniqueString(),
			'startDate' => "08/22/2020",
			'startTime' => "12:00 pm",
		));

		$task->refresh();

		$feed = $task->feed;

		$this->assertEquals(2, count($feed) - $feedInitialCount, "The feed was not updated two times when two attributes were changed");

	}

}