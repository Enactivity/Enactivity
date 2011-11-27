<?php
/**
 * Tests for {@link TaskUser::complete}
 * @author ajsharma
 */
class TaskUserCompleteTest extends DbTestCase
{
	/**
	 * Test that group insert works when group and user exist
	 */
	public function testTaskUserCompleteValid() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);

		$this->assertTrue(TaskUser::complete($task->id, $user->id), "new TaskUser was not completed");
		
		$taskUser = TaskUser::model()->findByAttributes(array(
			'taskId' => $task->id,
			'userId' => $user->id,
		));
		
		$this->assertNotNull($taskUser, "TaskUser sign up did not save task");
		$this->assertEquals(0, $taskUser->isTrash, "TaskUser was trashed on complete");
		$this->assertEquals(1, $taskUser->isCompleted, "TaskUser was completed on complete");
	}

	/**
	 * Test that completing the task user twice is ok
	 */
	public function testTaskUserCompleteValidTwiceValid() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);
		
		$this->assertTrue(TaskUser::complete($task->id, $user->id), "New TaskUser was not completed");
		$this->assertTrue(TaskUser::complete($task->id, $user->id), "Existing TaskUser was not completed");
	}
	
	/**
	 * Test that completing a signed up task works
	 */
	public function testTaskUserCompleteWasSignedUp() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);
		TaskUser::signUp($task->id, $user->id);
		
		$this->assertTrue(TaskUser::complete($task->id, $user->id), "Signed Up TaskUser was not completed");
		
		$taskUser = TaskUser::loadTaskUser($task->id, $user->id);
		
		$this->assertEquals(0, $taskUser->isTrash, "TaskUser was trashed on complete");
		$this->assertEquals(1, $taskUser->isCompleted, "TaskUser was completed on complete");
	}
	
	/**
	* Test that completing a quitted task works
	*/
	public function testTaskUserCompleteWasQuit() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);
		TaskUser::signUp($task->id, $user->id);
		TaskUser::quit($task->id, $user->id);
	
		$this->assertTrue(TaskUser::complete($task->id, $user->id), "Quitted TaskUser was not completed");
	
		$taskUser = TaskUser::loadTaskUser($task->id, $user->id);
	
		$this->assertEquals(0, $taskUser->isTrash, "TaskUser was trashed on complete");
		$this->assertEquals(1, $taskUser->isCompleted, "TaskUser was completed on complete");
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