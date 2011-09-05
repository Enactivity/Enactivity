<?php
/**
 * Tests around completing a task
 * @author ajsharma
 */
class CompleteTaskTest extends DbTestCase {

	public function setUp() {
		parent::setUp();
	}

	/**
	 * Test that a task is not completed on
	 */
	public function testIncompletedOnInsertTask() {
		$task = TaskFactory::insert();
		$this->assertFalse($task->getIsCompleted(), "Task was completed on insert");
		$this->assertFalse($task->isCompleted, "Task was completed on insert");
	}

	/**
	 * Test that a task is complete when only user is completed
	 */
	public function testCompletedTask() {
		$task = TaskFactory::insert();
		$task->userComplete(Yii::app()->user->id);

		$this->assertTrue($task->getIsCompleted(), "Task was not completed when only user is completed");
		$this->assertTrue($task->isCompleted, "Task was not completed when only user is completed");
	}

	/**
	 * Test that a task is complete when only user is completed
	 */
	public function testIncompletedTask() {
		$task = TaskFactory::insert();
		$task->userUncomplete(Yii::app()->user->id);

		$this->assertFalse($task->getIsCompleted(), "Task was not completed when only user is not completed");
		$this->assertFalse($task->isCompleted, "Task was not completed when only user is not completed");
	}

	/**
	 * Test that a task is completed when all the users signed up for it are completed
	 */
	public function testCompletedByMultipleUsers() {
		$task = TaskFactory::insert();

		$userA = UserFactory::insert();
		$userB = UserFactory::insert();

		$task->userComplete($userA->id);
		$task->userComplete($userB->id);

		$this->assertTrue($task->getIsCompleted(), "Task was not completed when only all users are completed");
		$this->assertTrue($task->isCompleted, "Task was not completed when only user all users are completed");
	}

	/**
	 * Verify that a task is not completed when only some of the users signed up for it are completed
	 */
	public function testIncompleteWithMultipleUsers() {
		$task = TaskFactory::insert();

		$userA = UserFactory::insert();
		$userB = UserFactory::insert();

		$task->userComplete($userA->id);
		$task->userUncomplete($userB->id);

		$this->assertFalse($task->getIsCompleted(), "Task was completed when one user was not completed");
		$this->assertFalse($task->isCompleted, "Task was completed when one user was not completed");
	}
}