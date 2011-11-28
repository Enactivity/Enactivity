<?php
/**
 * Tests around deleting a task
 * @author ajsharma
 */
class DeleteTaskTest extends DbTestCase {

	public function setUp() {
		parent::setUp();
	}

	/**
	 * Verify that a task can be deleted
	 */
	public function testDeleteTask() {
		$task = TaskFactory::insert();
		$deleted = $task->deleteNode();

		$foundTask = Task::model()->findByPk($task->id);

		$this->assertTrue($deleted, "Task was not deleted");
		$this->assertNull($foundTask, "Task was not deleted");
	}

	/**
	 * Verify that a task can be deleted
	 */
	public function testDeleteTaskWithUsers() {
		$task = TaskFactory::insert();

		$userA = UserFactory::insert();
		$userB = UserFactory::insert();

		$task->participate($userA->id);
		$task->participate($userB->id);

		$deleted = $task->deleteNode();

		$foundTask = Task::model()->findByPk($task->id);

		$this->assertTrue($deleted, "Task with participants was not deleted");
		$this->assertNull($foundTask, "Task with participants was not deleted");
	}

	/**
	 * Verify that a task with subtasks can be deleted
	 */
	public function testDeleteTaskWithSubtask() {
		$task = TaskFactory::insert();
		$subtaskA = TaskFactory::insertSubTask($task->id);
		$subtaskB = TaskFactory::insertSubTask($task->id);

		$deleted = $task->deleteNode();

		$foundTask = Task::model()->findByPk($task->id);
		$foundTaskA = Task::model()->findByPk($subtaskA->id);
		$foundTaskB = Task::model()->findByPk($subtaskB->id);

		$this->assertTrue($deleted, "Task was not deleted");
		$this->assertNull($foundTask, "Task was not deleted");
		$this->assertNull($foundTaskA, "Task was not deleted");
		$this->assertNull($foundTaskB, "Task was not deleted");
	}

	/**
	 * Verify that a subtask can be deleted
	 */
	public function testDeleteSubtask() {
		$task = TaskFactory::insert();
		$subtaskA = TaskFactory::insertSubTask($task->id);
		$subtaskB = TaskFactory::insertSubTask($task->id);

		$deletedA = $subtaskA->deleteNode();
		$deletedB = $subtaskB->deleteNode();

		$foundTask = Task::model()->findByPk($task->id);
		$foundTaskA = Task::model()->findByPk($subtaskA->id);
		$foundTaskB = Task::model()->findByPk($subtaskB->id);

		$this->assertTrue($deletedA, "SubtaskA was not deleted");
		$this->assertTrue($deletedB, "SubtaskB was not deleted");
		$this->assertNotNull($foundTask, "Parent task was deleted when deleting subtask");
		$this->assertNull($foundTaskA, "Task was not deleted");
		$this->assertNull($foundTaskB, "Task was not deleted");
	}

}