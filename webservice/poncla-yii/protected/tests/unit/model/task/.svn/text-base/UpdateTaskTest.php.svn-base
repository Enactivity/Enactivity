<?php

class UpdateTaskTest extends DbTestCase
{
	public $task;
	
	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
	}
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->task = TaskFactory::insert();
	}
	
	protected function tearDown()
	{
		parent::tearDown();
	}
 
	public static function tearDownAfterClass()
	{
		parent::tearDownAfterClass();
	}
	
	public function testUpdateTaskValid() 
	{
	    $this->task = Task::model()->findByPk($this->task->id);
	    
		$name = "updated test testing";
		$starts = null;
	    
	    $attributes = array(
			'name' => $name,
	    	'starts' => $starts,
	    );
	    
	   	$this->assertTrue($this->task->updateTask($attributes), 'valid task was not saved');
	   	$this->assertTrue($this->task instanceof Task, 'found task not a Task object');
		$this->assertNotNull($this->task->id, 'task id attribute was not assigned');
		$this->assertNotNull($this->task->name, 'task name attribute was assigned');
		$this->assertNotNull($this->task->isTrash, 'task isTrash attribute was not assigned');
		$this->assertNotNull($this->task->created, 'task created attribute was not assigned');
		$this->assertNotNull($this->task->modified, 'task modified attribute was not assigned');
	
		$this->assertEquals($name, $this->task->name, 'task name was not saved');
		$this->assertEquals($starts, $this->task->starts, 'task starts was not saved');
	}
	
	/**
	 * Updating a Valid Task with DateTime
	 */
	
	public function testUpdateTaskValidwithDateTime() 
	{
	    $this->task = Task::model()->findByPk($this->task->id);
	    
		$name = "updated test testing";
		$starts = date ("Y-m-d H:i:s", strtotime("-1 hours"));
	    
	   	$attributes = array(
			'name' => $name,
	    	'starts' => $starts,
	    );
	    
 		$this->assertTrue($this->task->updateTask($attributes), 'valid task was not saved');	   	
	   	$this->assertTrue($this->task instanceof Task, 'found task not a Task object');	 
		$this->assertNotNull($this->task->id, 'task id attribute was not assigned');
		$this->assertNotNull($this->task->name, 'task name attribute was assigned');
		$this->assertNotNull($this->task->isTrash, 'task isTrash attribute was not assigned');
		$this->assertNotNull($this->task->created, 'task created attribute was not assigned');
		$this->assertNotNull($this->task->modified, 'task modified attribute was not assigned');
	
		$this->assertEquals($name, $this->task->name, 'task name was not saved');
		$this->assertEquals($starts, $this->task->starts, 'task starts was not saved');
		
	}
	
	/**
	 * Updating Task with a Null Name
	 */
	
	public function testUpdateTaskWithNullName()
	{
		$this->task = Task::model()->findByPk($this->task->id);
		
		$name = null;
		$starts = date ("Y-m-d H:i:s", strtotime("-1 hours"));
		
		$this->task->setAttributes(array(
			'name' => $name,
	    	'starts' => $starts,
	    ));
	    
		$this->assertNull($this->task->name, 'save name is not null');
		$this->assertFalse($this->task->updateTask(), 'task without name was saved: ');
	}
	
	/**
	 * Updating task with trimmed name and trimmed DateTime
	 */
	
	public function testUpdateTaskTrimSpacesWithDateTime() 
	{
		$name = StringUtils::createRandomString(10);
		$starts = date ("Y-m-d H:i:s", strtotime("-1 hours"));
		
		$this->task = Task::model()->findByPk($this->task->id);
		
		$this->task->setAttributes(array(
			'name' => ' ' . $name . ' ',
	    	'starts' => ' ' . $starts . ' ',
	    ));
	    
	    $this->assertTrue($this->task->updateTask(), 'valid task was not saved');	   	
	   	$this->assertTrue($this->task instanceof Task, 'found task not a Task object');	 
		$this->assertNotNull($this->task->id, 'task id attribute was not assigned');
		$this->assertNotNull($this->task->name, 'task name attribute was assigned');
		$this->assertNotNull($this->task->isTrash, 'task isTrash attribute was not assigned');
		$this->assertNotNull($this->task->created, 'task created attribute was not assigned');
		$this->assertNotNull($this->task->modified, 'task modified attribute was not assigned');
	
		$this->assertEquals($name, $this->task->name, 'task name was not saved');
		$this->assertEquals($starts, $this->task->starts, 'task starts was not saved');
	}
	
	/**
	 * Updating task with only startDate
	 */
	
	public function testSetDate()
	{
		$this->task = Task::model()->findByPk($this->task->id);
		$name = StringUtils::createRandomString(10);
		$today = date ('m/d/Y', time());
		
		$this->task->setAttributes(array(
			'name' => $name,
	    	'startDate' => $today,
	    ));
	    
	    $this->assertTrue($this->task->updateTask(), 'valid task was not saved');
	    $this->task = Task::model()->findByPk($this->task->id);
	 	$this->assertEquals($today, $this->task->startDate, 'task startDate was not saved');
	    
	}
	
}