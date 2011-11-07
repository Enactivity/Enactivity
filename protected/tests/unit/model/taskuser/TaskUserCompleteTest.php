<?php
/**
 * Tests for {@link TaskUser::complete}
 * @author ajsharma
 */
class TaskUserCompleteTaskUserTest extends DbTestCase
{
	/**
	 * Test that group insert works when group and user exist
	 */
	public function testTaskUserCompleteValid() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);

		$this->assertTrue(TaskUser::complete($task->id, $user->id), "Task user was not signed up: " . CVarDumper::dumpAsString($taskUser->errors));
		
		$taskUser = TaskUser::model()->findByAttributes(array(
			'taskId' => $task->id,
			'userId' => $user->id,
		));
		
		$this->assertNotNull($taskUser, "TaskUser sign up did not save task");
		$this->assertEquals(0, $taskUser->isTrash, "TaskUser was trashed on complete");
		$this->assertEquals(1, $taskUser->isCompleted, "TaskUser was completed on complete");
	}

	/**
	 * Test that group insert works throw exception
	 */
	public function testTaskUserCompleteValidTwiceValid() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);
		
		$this->assertTrue(TaskUser::complete($task->id, $user->id), "Task user was not signed up: " . CVarDumper::dumpAsString($taskUser->errors));
		$this->assertTrue(TaskUser::complete($task->id, $user->id), "Task user was not signed up: " . CVarDumper::dumpAsString($taskUser->errors));
	}

	/**
	 * Test that group insert fails when group is null
	 * @expectedException CHttpException
	 */
	public function testTaskUserCompleteTaskNullIsInvalid() {
		$user = UserFactory::insert();
		TaskUser::complete(null, $user->id);
	}

	/**
	 * Test that group insert fails when user is null
	 * @expectedException CHttpException
	 */
	public function testTaskUserCompleteUserNullIsInvalid() {
		$task = TaskFactory::insert();
		TaskUser::complete($task->id, null);
	}

	/**
	 * Test that group insert fails when group is null
	 * @expectedException CHttpException
	 */
	public function testTaskUserCompleteGroupAndUserNullIsInvalid() {
		TaskUser::complete(null, null);
	}
}