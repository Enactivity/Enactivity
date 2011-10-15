<?php

class TrashTaskTest extends DbTestCase
{
			
	/**
	 * Create a valid task
	 */
	public function testTrashNewTask() {
		$task = TaskFactory::insert();
		
		try {
			$this->assertTrue($task->trash(), "New task could not be trashed");
		}
		catch(Exception $e) {
			$this->fail('Task->trash() threw exception: ' . $e->getMessage());
		}
		
		$this->assertEquals(1, $task->isTrash, 'trash call did not update isTrash value');
	}
	
	/**
	 * Create a valid task
	 */
	public function testUnTrashNewTask() {
		$task = TaskFactory::insert();
		
		try {
			$this->assertTrue($task->untrash(), "New task could not be untrashed");
		}
		catch(Exception $e) {
			$this->fail('Task->untrash() threw exception: ' . $e->getMessage());
		}
		
		$this->assertEquals(0, $task->isTrash, 'untrash call did not update isTrash value');
	}
}
