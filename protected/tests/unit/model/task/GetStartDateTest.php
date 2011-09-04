<?php
/**
 * Tests for Task->getStartDate()
 */
class GetStartDateTest extends DbTestCase
{

	public $task;
	
	public function setUp()
	{
		parent::setUp();
		
		// create a new task
		$this->task = new Task();
		$this->task->name = 'test_' . time();
		$this->task->saveNode();
	}
	
	/**
	 * Get start date when starts is null
	 */
	public function testGetStartDateWithNoDate() {
		
		// try method
		try {
			$startDate = $this->task->getStartDate();
			$this->assertNull($startDate, 'Start date was not null when starts was null');
		}
		catch(Exception $e) {
			$this->fail('getStartDate() with no starts threw exception: ' . $e->getMessage());
		}
	}
	
	public function testGetStartDateWithNoDateMagic() {
		// try magic method
		try {
			$startDate = $this->task->startDate;
			$this->assertNull($startDate, 'startDate was not null when starts was null');
		}
		catch(Exception $e) {
			$this->fail('startDate with no starts threw exception: ' . $e->getMessage());
		}
	}
	
	public function testGetStartDateWithDate() {
		$now = time();
		$this->task->starts = date('m/d/Y H:i:00', $now);
		$this->task->saveNode();
		
		// try method
		try {
			$startDate = $this->task->getStartDate();
			$this->assertEquals($startDate, date('Y-m-d', $now), 'Get start date does not match');
		}
		catch(Exception $e) {
			$this->fail('getStartDate() with starts threw exception: ' . $e->getMessage());
		}
	}
	
	public function testGetStartDateWithDateMagic() {
		$now = time();
		$this->task->starts = date('m/d/Y H:i:00', $now);
		$this->task->saveNode();
		
		// try method
		try {
			$startDate = $this->task->startDate;
			$this->assertEquals($startDate, date('Y-m-d', $now), 'Get start date does not match');
		}
		catch(Exception $e) {
			$this->fail('startDate with starts threw exception: ' . $e->getMessage());
		}
	}
	
}