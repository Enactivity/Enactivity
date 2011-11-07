<?php
/**
 * Tests for {@link TaskUser::resume}
 * @author ajsharma
 */
class TaskUserResumeTest extends DbTestCase
{
	/**
	 * Test that group insert works when group and user exist
	 */
	public function testTaskUserResumeValid() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);

		$this->assertTrue(TaskUser::resume($task->id, $user->id), "Task user was not signed up: " . CVarDumper::dumpAsString($taskUser->errors));
		
		$taskUser = TaskUser::model()->findByAttributes(array(
			'taskId' => $task->id,
			'userId' => $user->id,
		));
		
		$this->assertNotNull($taskUser, "TaskUser sign up did not save task");
		$this->assertEquals(0, $taskUser->isTrash, "TaskUser was trashed on resume");
		$this->assertEquals(0, $taskUser->isCompleted, "TaskUser was completed on resume");
	}

	/**
	 * Test that group insert works throw exception
	 */
	public function testTaskUserResumeValidTwiceValid() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);
		
		$this->assertTrue(TaskUser::resume($task->id, $user->id), "Task user was not signed up: " . CVarDumper::dumpAsString($taskUser->errors));
		$this->assertTrue(TaskUser::resume($task->id, $user->id), "Task user was not signed up: " . CVarDumper::dumpAsString($taskUser->errors));
	}

	/**
	 * Test that group insert fails when group is null
	 * @expectedException CHttpException
	 */
	public function testTaskUserResumeTaskNullIsInvalid() {
		$user = UserFactory::insert();
		TaskUser::resume(null, $user->id);
	}

	/**
	 * Test that group insert fails when user is null
	 * @expectedException CHttpException
	 */
	public function testTaskUserResumeUserNullIsInvalid() {
		$task = TaskFactory::insert();
		TaskUser::resume($task->id, null);
	}

	/**
	 * Test that group insert fails when group is null
	 * @expectedException CHttpException
	 */
	public function testTaskUserResumeGroupAndUserNullIsInvalid() {
		TaskUser::resume(null, null);
	}
}