<?php
/**
 * Tests for {@link TaskUser::insertTaskUser}
 * @author ajsharma
 */
class TaskUserInsertTaskUserTest extends DbTestCase
{
	/**
	 * Test that group insert works when group and user exist
	 */
	public function testTaskUserInsertValid() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);

		$taskUser = new TaskUser();

		$this->assertTrue($taskUser->insertTaskUser($task->id, $user->id), "Task user was not inserted: " . CVarDumper::dumpAsString($taskUser->errors));
		$this->assertEquals(0, $taskUser->isTrash, "TaskUser was trashed on insert");
		$this->assertEquals(0, $taskUser->isCompleted, "TaskUser was completed on insert");
	}

	/**
	 * Test that group insert works throw exception
	 * @expectedException CDbException
	 */
	public function testTaskUserInsertValidTwiceException() {
		$task = TaskFactory::insert();
		$user = UserFactory::insert(array(), $task->groupId);

		$taskUser = new TaskUser();
		$taskUser->insertTaskUser($task->id, $user->id);
		$taskUser->insertTaskUser($task->id, $user->id); // call it twice
	}

	/**
	 * Test that group insert fails when group is null
	 */
	public function testTaskUserInsertGroupNullIsInvalid() {
		$user = UserFactory::insert();

		$taskUser = new TaskUser();

		$this->assertFalse($taskUser->insertTaskUser(null, $user->id), "Task user was inserted: " . CVarDumper::dumpAsString($taskUser->errors));
		$this->assertNotNull($taskUser->getError('taskId'), "No error set on null group");
	}

	/**
	 * Test that group insert fails when user is null
	 */
	public function testTaskUserInsertUserNullIsInvalid() {
		$task = TaskFactory::insert();

		$taskUser = new TaskUser();

		$this->assertFalse($taskUser->insertTaskUser($task->id, null), "Task user was inserted: " . CVarDumper::dumpAsString($taskUser->errors));
		$this->assertNotNull($taskUser->getError('userId'), "No error set on null user");
	}

	/**
	 * Test that group insert fails when group is null
	 */
	public function testTaskUserInsertGroupAndUserNullIsInvalid() {
		$taskUser = new TaskUser();

		$this->assertFalse($taskUser->insertTaskUser(null, null), "Task user was inserted: " . CVarDumper::dumpAsString($taskUser->errors));
		$this->assertNotNull($taskUser->getError('taskId'), "No error set on null group");
		$this->assertNotNull($taskUser->getError('userId'), "No error set on null user");
	}
}