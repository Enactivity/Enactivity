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
	 * Test that a task is complete when only user is completed
	 * Enter description here ...
	 */
	public function testCompleteTask() {
		$task = TaskFactory::insert();
		$task->userComplete();
		
		$this->assertTrue($task->getIsCompleted(), "Task was not completed");
	}
	
	public function testUncompleteTask() {
		$task = TaskFactory::insert();
		$task->userUncomplete();
	
		$this->assertFalse($task->getIsCompleted(), "Task was not completed");
	}
}