<?php
/**
 * Tests {@link Task::incrementParticipantCounts}
 * @author ajsharma
 */
class TaskIncrementParticipantsCountTest extends DbTestCase {
	
	/**
	 * Tests that incrementing a root task increases just that task
	 */
	public function testIncrementParticipantRootTask() {
		$task = TaskFactory::insert();
		
		$this->assertEquals(1, $task->incrementParticipantCounts(1, 1), "Incorrect number of tasks were updated by incrementParticipantCounts");
		
		$this->assertEquals(1, (int) $task->participantsCount, "Task's participant count was not incremented by incrementParticipantCounts");
		$this->assertEquals(1, (int) $task->participantsCompletedCount, "Task's participant completed count was not incremented by incrementParticipantCounts");
	}
	
	/**
	 * Tests that incrementing a sub task increases a task and its parent and grandparent
	*/
	public function testIncrementParticipantGrandTask() {
		$task = TaskFactory::insert();
		$subtask = TaskFactory::insertSubTask($task->id);
		$grandtask = TaskFactory::insertSubTask($subtask->id);
	
		$this->assertEquals(3, $grandtask->incrementParticipantCounts(1, 1), "Incorrect number of tasks were updated by incrementParticipantCounts");
	
		// reload root task's data
		$task->refresh();
		$subtask->refresh();
	
		$this->assertEquals(1, (int) $task->participantsCount, "Root task participant count was not incremented when incrementing its grandchild");
		$this->assertEquals(1, (int) $task->participantsCompletedCount, "Root task participant completed count was not incremented when incrementing its grandchild");
		
		$this->assertEquals(1, (int) $subtask->participantsCount, "Task participant count was not incremented when incrementing its child");
		$this->assertEquals(1, (int) $subtask->participantsCompletedCount, "Task participant completed count was not incremented when incrementing its child");
		
		$this->assertEquals(1, (int) $grandtask->participantsCount, "Task's participant count was not incremented by incrementParticipantCounts");
		$this->assertEquals(1, (int) $grandtask->participantsCompletedCount, "Task's participant completed count was not incremented by incrementParticipantCounts");
	}
	
	/**
	 * Test that exceptions are thrown if the params are null
	 * @expectedException CDbException
	*/
	public function testIncrementParticipantCountsNullCountParam() {
		$task = TaskFactory::insert();
		$task->incrementParticipantCounts(null, 1);
	}
	
	/**
	* Test that exceptions are thrown if the params are null
	* @expectedException CDbException
	*/
	public function testIncrementParticipantCountsNullCompletedCountParams() {
		$task = TaskFactory::insert();
		$task->incrementParticipantCounts(1, null);
	}
	
	/**
	 * Test that exceptions are thrown if the params are null
	 * @expectedException CDbException
	 */
	public function testIncrementParticipantCountsNullParams() {
		$task = TaskFactory::insert();
		$task->incrementParticipantCounts(null, null);
	}
}