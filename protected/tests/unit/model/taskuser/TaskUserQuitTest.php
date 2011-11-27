<?php
/**
 * Tests for {@link TaskUser::quit}
 * @author ajsharma
 */
class TaskUserQuitTest extends DbTestCase
{
	/**
	 * Test that taskuser quit works when group and user exist
	 */
	public function testTaskUserQuitValid() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);

		TaskUser::signUp($task->id, $user->id);
		$this->assertTrue(TaskUser::quit($task->id, $user->id), "Task user was not signed up");

		$taskUser = TaskUser::loadTaskUser($task->id, $user->id);
		$this->assertNotNull($taskUser, "TaskUser sign up did not save task");
		$this->assertEquals(1, $taskUser->isTrash, "TaskUser was not trashed on quit");
		$this->assertEquals(0, $taskUser->isCompleted, "TaskUser was completed on quit");
	}

	/**
	 * Test that quitting a signed up task
	 */
	public function testTaskUserQuitValidTwiceValid() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);

		TaskUser::signUp($task->id, $user->id);
		$this->assertTrue(TaskUser::quit($task->id, $user->id), "Task user did not quit");
		$this->assertTrue(TaskUser::quit($task->id, $user->id), "Task user did not quit");
		
		$taskUser = TaskUser::loadTaskUser($task->id, $user->id);
		$this->assertEquals(1, $taskUser->isTrash, "TaskUser was not trashed on quit");
		$this->assertEquals(0, $taskUser->isCompleted, "TaskUser was completed on quit");
	}
	
	/**
	* Test that quitting a completed task is acceptable
	*/
	public function testTaskUserQuitWasCompleted() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);
	
		TaskUser::complete($task->id, $user->id);
		$this->assertTrue(TaskUser::quit($task->id, $user->id), "Task user did not quit completed task");
	
		$taskUser = TaskUser::loadTaskUser($task->id, $user->id);
		$this->assertEquals(1, $taskUser->isTrash, "TaskUser was not trashed on quit");
		$this->assertEquals(0, $taskUser->isCompleted, "TaskUser was completed on quit");
	}

	/**
	 * Test that taskuser quit fails when its a new taskuser
	 * @expectedException CHttpException
	 */
	public function testTaskUserQuitNewTaskUserFails() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);
		
		TaskUser::quit($task->id, $user->id);
	}

	/**
	 * Test that taskuser quit fails when group is null
	 * @expectedException CHttpException
	 */
	public function testTaskUserQuitTaskNullIsInvalid() {
		$user = UserFactory::insert();
		TaskUser::quit(null, $user->id);
	}

	/**
	 * Test that taskuser quit fails when user is null
	 * @expectedException CHttpException
	 */
	public function testTaskUserQuitUserNullIsInvalid() {
		$task = TaskFactory::insert();
		TaskUser::quit($task->id, null);
	}

	/**
	 * Test that taskuser quit fails when group is null
	 * @expectedException CHttpException
	 */
	public function testTaskUserQuitGroupAndUserNullIsInvalid() {
		TaskUser::quit(null, null);
	}
}