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
	 * Verify that a task is not completed on initial insert
	 */
	public function testIncompletedOnInsertTask() {
		$task = TaskFactory::insert();
		$this->assertFalse($task->getIsCompleted(), "Task was completed on insert");
		$this->assertFalse($task->isCompleted, "Task was completed on insert");
	}

	/**
	 * Verify that a task is complete when only user is completed
	 */
	public function testCompletedTask() {
		$task = TaskFactory::insert();
		$task->userComplete(Yii::app()->user->id);

		$this->assertTrue($task->getIsCompleted(), "Task was not completed when only user is completed");
		$this->assertTrue($task->isCompleted, "Task was not completed when only user is completed");
	}

	/**
	 * Verify that a task is complete when only user is completed
	 */
	public function testIncompletedTask() {
		$task = TaskFactory::insert();
		$task->userUncomplete(Yii::app()->user->id);

		$this->assertFalse($task->getIsCompleted(), "Task was not completed when only user is not completed");
		$this->assertFalse($task->isCompleted, "Task was not completed when only user is not completed");
	}

	/**
	 * Verify that a task is completed when all the users signed up for it are completed
	 */
	public function testCompletedByMultipleUsers() {
		$task = TaskFactory::insert();

		$userA = UserFactory::insert();
		$userB = UserFactory::insert();

		$task->userComplete($userA->id);
		$task->userComplete($userB->id);

		$this->assertTrue($task->getIsCompleted(), "Task was not completed when all users are completed");
		$this->assertTrue($task->isCompleted, "Task was not completed when all users are completed");
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

	/**
	 * Verify that a task is completed when everyone signed up for its children are completed
	 */
	public function testCompletedSubtaskOneChild() {
		$task = TaskFactory::insert();
		$subtaskA = TaskFactory::makeSubTask($task->id);

		$userA = UserFactory::insert();
		$userB = UserFactory::insert();

		$subtaskA->userComplete($userA->id);
		$subtaskA->userComplete($userB->id);

		$this->assertTrue($subtaskA->getIsCompleted(), "Subtask was not completed when all users are completed");
		$this->assertTrue($subtaskA->isCompleted, "Subask was not completed when all users are completed");

		$this->assertTrue($task->getIsCompleted(), "Parent task was not completed when all users of subtask are completed");
		$this->assertTrue($task->isCompleted, "Parent task was not completed when all users of subtasks are completed");
	}

	/**
	 * Verify that a task is completed when everyone signed up for its children are completed
	 */
	public function testCompletedSubtaskMultipleChildren() {
		$task = TaskFactory::insert();
		$subtaskA = TaskFactory::makeSubTask($task->id);
		$subtaskB = TaskFactory::makeSubTask($task->id);

		$userA = UserFactory::insert();
		$userB = UserFactory::insert();

		$subtaskA->userComplete($userA->id);
		$subtaskA->userComplete($userB->id);

		$subtaskB->userComplete($userA->id);
		$subtaskB->userComplete($userB->id);

		$this->assertTrue($subtaskA->getIsCompleted(), "Subtask was not completed when all users are completed");
		$this->assertTrue($subtaskA->isCompleted, "Subask was not completed when all users are completed");

		$this->assertTrue($subtaskB->getIsCompleted(), "Subtask was not completed when all users are completed");
		$this->assertTrue($subtaskB->isCompleted, "Subask was not completed when all users are completed");

		$this->assertTrue($task->getIsCompleted(), "Parent task was not completed when all users of subtask are completed");
		$this->assertTrue($task->isCompleted, "Parent task was not completed when all users of subtasks are completed");
	}

	/**
	 * Verify that a task is not completed when not everyone signed up for its children are completed
	 */
	public function testIncompletedSubtaskMultipleChildren() {
		$task = TaskFactory::insert();
		$subtaskA = TaskFactory::makeSubTask($task->id);
		$subtaskB = TaskFactory::makeSubTask($task->id);

		$userA = UserFactory::insert();
		$userB = UserFactory::insert();

		$subtaskA->userComplete($userA->id);
		$subtaskA->userComplete($userB->id);

		$subtaskB->userComplete($userA->id);
		$subtaskB->userUncomplete($userB->id);

		$this->assertTrue($subtaskA->getIsCompleted(), "Subtask was not completed when all users are completed");
		$this->assertTrue($subtaskA->isCompleted, "Subask was not completed when all users are completed");

		$this->assertFalse($subtaskB->getIsCompleted(), "Subtask was completed when not all users are completed");
		$this->assertFalse($subtaskB->isCompleted, "Subask was completed when not all users are completed");

		$this->assertFalse($task->getIsCompleted(), "Parent task was completed when not all users of subtask are completed");
		$this->assertFalse($task->isCompleted, "Parent task was completed when not all users of subtasks are completed");
	}

	/**
	 * Verify that Task completion ignores trashed subtasks
	 */
	public function testCompletedTaskWithTrashedSubtasks() {
		$task = TaskFactory::insert();
		$subtaskA = TaskFactory::makeSubTask($task->id);
		$subtaskB = TaskFactory::makeSubTask($task->id);

		$userA = UserFactory::insert();
		$userB = UserFactory::insert();

		$subtaskA->userComplete($userA->id);
		$subtaskA->userComplete($userB->id);

		$subtaskB->trash()->saveNode();

		$this->assertTrue($subtaskA->getIsCompleted(), "Subtask was not completed when all users are completed");
		$this->assertTrue($subtaskA->isCompleted, "Subask was not completed when all users are completed");

		$this->assertTrue($task->getIsCompleted(), "Parent task was not completed when all users of subtask are completed");
		$this->assertTrue($task->isCompleted, "Parent task was not completed when all users of subtasks are completed");
	}
}