<?php
/**
 * Tests around participating in a task
 * @author ajsharma
 */
class TaskParticipateTest extends DbTestCase {

	/**
	 * Verify that a task is not complete when only user is not completed
	 */
	public function testParticipateTask() {
		$task = TaskFactory::insert();
		$task->participate(Yii::app()->user->id);
		$task->refresh();

		$this->assertFalse($task->getIsCompleted(), "Task was completed when only user is not completed");
		$this->assertFalse($task->isCompleted, "Task was completed when only user is not completed");
		
		$this->assertEquals(1, $task->participantsCount);
		$this->assertEquals(0, $task->participantsCompletedCount);
	}

	/**
	 * Verify that a task is not completed when all the users signed up for it are not completed
	 */
	public function testParticipateByMultipleUsers() {
		$task = TaskFactory::insert();

		$userA = UserFactory::insert();
		$userB = UserFactory::insert();

		$task->participate($userA->id);
		$task->participate($userB->id);
		
		$task->refresh();

		$this->assertFalse($task->getIsCompleted(), "Task was not completed when all users are completed");
		$this->assertFalse($task->isCompleted, "Task was not completed when all users are completed");
		
		$this->assertEquals(2, $task->participantsCount);
		$this->assertEquals(0, $task->participantsCompletedCount);
	}

	/**
	 * Verify that a task is not completed when everyone signed up for its children are not completed
	 */
	public function testParticipateSubtaskOneChild() {
		$task = TaskFactory::insert();
		$subtaskA = TaskFactory::insertSubTask($task->id);

		$userA = UserFactory::insert();
		$userB = UserFactory::insert();

		$subtaskA->participate($userA->id);
		$subtaskA->participate($userB->id);
		
		$task->refresh();
		$subtaskA->refresh();

		$this->assertFalse($task->getIsCompleted(), "Parent task was not completed when all users of subtask are completed");
		$this->assertFalse($task->isCompleted, "Parent task was not completed when all users of subtasks are completed");
		
		$this->assertFalse($subtaskA->getIsCompleted(), "Subtask was not completed when all users are completed");
		$this->assertFalse($subtaskA->isCompleted, "Subtask was not completed when all users are completed");
		
		$this->assertEquals(2, $task->participantsCount);
		$this->assertEquals(0, $task->participantsCompletedCount);
		
		$this->assertEquals(2, $subtaskA->participantsCount);
		$this->assertEquals(0, $subtaskA->participantsCompletedCount);
	}
}