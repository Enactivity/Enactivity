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
		
		$this->task = new Task();
	    $this->task->setAttributes(array(
			'name' => "test testing",
	    ));
	    $this->task->saveNode();
	   	$this->task->scenario = Task::SCENARIO_UPDATE;
		
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
	    
	    $this->task->setAttributes(array(
			'name' => $name,
	    	'starts' => $starts,
	    ));
	    
	   	$this->task->saveNode();

	   	$this->assertTrue($this->task->saveNode(), 'valid task was not saved');
	   	$this->assertTrue($this->task instanceof Task, 'found task not a Task object');
		$this->assertNotNull($this->task->id, 'task id attribute was not assigned');
		$this->assertNotNull($this->task->name, 'task name attribute was assigned');
		$this->assertNotNull($this->task->isTrash, 'task isTrash attribute was not assigned');
		$this->assertNotNull($this->task->created, 'task created attribute was not assigned');
		$this->assertNotNull($this->task->modified, 'task modified attribute was not assigned');
	
		$this->assertEquals($name, $this->task->name, 'task name was not saved');
		$this->assertEquals($starts, $this->task->starts, 'task starts was not saved');
	}
	
	public function testUpdateTaskValidwithDateTime() 
	{
	    $this->task = Task::model()->findByPk($this->task->id);
	    
		$name = "updated test testing";
		$starts = date ("Y-m-d H:i:s", strtotime("-1 hours"));
	    
	    $this->task->setAttributes(array(
			'name' => $name,
	    	'starts' => $starts,
	    ));
	    
	   	$this->task->saveNode();
	   	
 		$this->assertTrue($this->task->saveNode(), 'valid task was not saved');	   	
	   	$this->assertTrue($this->task instanceof Task, 'found task not a Task object');	 
		$this->assertNotNull($this->task->id, 'task id attribute was not assigned');
		$this->assertNotNull($this->task->name, 'task name attribute was assigned');
		$this->assertNotNull($this->task->isTrash, 'task isTrash attribute was not assigned');
		$this->assertNotNull($this->task->created, 'task created attribute was not assigned');
		$this->assertNotNull($this->task->modified, 'task modified attribute was not assigned');
	
		$this->assertEquals($name, $this->task->name, 'task name was not saved');
		$this->assertEquals($starts, $this->task->starts, 'task starts was not saved');
		
	}
	public function testUpdateTaskTrimSpacesWithDateTime() 
	{
		$name = StringUtils::createRandomString(10);
		$starts = date ("Y-m-d H:i:s", strtotime("-1 hours"));
		
		$this->task = Task::model()->findByPk($this->task->id);
		
		$this->task->setAttributes(array(
			'name' => ' ' . $name . ' ',
	    	'starts' => ' ' . $starts . ' ',
	    ));
	    
	    $this->task->saveNode();
	    
	    $this->assertTrue($this->task->saveNode(), 'valid task was not saved');	   	
	   	$this->assertTrue($this->task instanceof Task, 'found task not a Task object');	 
		$this->assertNotNull($this->task->id, 'task id attribute was not assigned');
		$this->assertNotNull($this->task->name, 'task name attribute was assigned');
		$this->assertNotNull($this->task->isTrash, 'task isTrash attribute was not assigned');
		$this->assertNotNull($this->task->created, 'task created attribute was not assigned');
		$this->assertNotNull($this->task->modified, 'task modified attribute was not assigned');
	
		$this->assertEquals($name, $this->task->name, 'task name was not saved');
		$this->assertEquals($starts, $this->task->starts, 'task starts was not saved');
	}
}