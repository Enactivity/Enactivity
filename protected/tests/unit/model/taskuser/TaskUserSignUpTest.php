<?php
/**
 * Tests for {@link TaskUser::signUp}
 * @author ajsharma
 */
class TaskUserSignUpTaskUserTest extends DbTestCase
{
	/**
	 * Test that group insert works when group and user exist
	 */
	public function testTaskUserSignUpValid() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);

		$this->assertTrue(TaskUser::signUp($task->id, $user->id), "Task user was not signed up");
		
		$taskUser = TaskUser::model()->findByAttributes(array(
			'taskId' => $task->id,
			'userId' => $user->id,
		));
		
		$this->assertNotNull($taskUser, "TaskUser sign up did not save task");
		$this->assertEquals(0, $taskUser->isTrash, "TaskUser was trashed on insert");
		$this->assertEquals(0, $taskUser->isCompleted, "TaskUser was completed on insert");
	}

	/**
	 * Test that group insert works throw exception
	 */
	public function testTaskUserSignUpValidTwiceValid() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);
		
		$this->assertTrue(TaskUser::signUp($task->id, $user->id), "Task user was not signed up");
		$this->assertTrue(TaskUser::signUp($task->id, $user->id), "Task user was not signed up");
	}

	/**
	 * Test that group insert fails when group is null
	 * @expectedException CHttpException
	 */
	public function testTaskUserSignUpTaskNullIsInvalid() {
		$user = UserFactory::insert();
		TaskUser::signUp(null, $user->id);
	}

	/**
	 * Test that group insert fails when user is null
	 * @expectedException CHttpException
	 */
	public function testTaskUserSignUpUserNullIsInvalid() {
		$task = TaskFactory::insert();
		TaskUser::signUp($task->id, null);
	}

	/**
	 * Test that group insert fails when group is null
	 * @expectedException CHttpException
	 */
	public function testTaskUserSignUpGroupAndUserNullIsInvalid() {
		TaskUser::signUp(null, null);
	}
}