<?php

require_once 'TestConstants.php';

class CreateEventTest extends DbTestCase
{

	public $group;
			
	public function setUp()
	{
		parent::setUp();
		
		$name = StringUtils::createRandomString(10);
		$slug = StringUtils::createRandomString(10);
		
		$this->group = new Group();
		
	    $this->group->setAttributes(array(
	        'name' => $name,
	        'slug' => $slug,
	    ));
	    $this->group->save();
	}
	
	/**
	 * Create a valid event
	 */
	public function testCreateEventValid() {
		
		$event = new Event();
		$event->setAttributes(array(
	    	'name' => "Test Event",
			'groupId' => $this->group->id,
			'starts' => "12/12/12 12:00:00",
			'ends' => "12/20/13 12:00:00"    
	    ));
	    
	    $this->assertTrue($event->save(), 'valid event was not saved');
			
	}
	
	/**
	 * Create a valid event and test if name is null
	 */
	public function testCreateEventWithNullName() {
		
		$name = null;
		$event = new Event();
		$event->setAttributes(array(
	    	'name' => $name,
			'groupId' => $this->group->id,
			'starts' => "12/12/12 12:00:00",
			'ends' => "12/20/13 12:00:00"    
	    ));
	    
	   $this->assertNull($event->name, 'save name is not null');
			
	}
	
	/**
	 * Create a valid event and ensure entries are trimmed
	 */
	public function testCreateEventTrimSpaces() {
		$name = "Test Event";
		$paddedName = ' ' . $name . ' ';
		$event = new Event();
		$event->setAttributes(array(
	    	'name' => $paddedName,
			'groupId' => $this->group->id,
			'starts' => "12/12/12 12:00:00",
			'ends' => "12/20/13 12:00:00"    
	    ));
	    
	   $this->assertTrue($event instanceof Event, 'found event not a Event object');
	   $this->assertTrue($event->save(), 'valid event was not saved');
	   $this->assertNotNull($event->created, 'event created was not set');
	   $this->assertNotNull($event->modified, 'event modified was not set');
			
	}
	
	/**
	 * Set name input over the acceptable lengths
	 */
    public function testCreateEventExceedMaximumNameInput() {
    	
		$name = StringUtils::createRandomString(255 + 1);

		$event = new Event();
		$event->setAttributes(array(
	    	'name' => $name,
			'groupId' => $this->group->id,
			'starts' => "12/12/12 12:00:00",
			'ends' => "12/20/13 12:00:00"    
	    ));
	 $this->assertFalse($event->save(), 'invalid event was saved');
	}
	
	/**
	 * Test event create when no name, starts and ends are set
	 */
	public function testCreateEventNoInput() {

		$name = null;
		$groupId = null;
		$starts = null;
		$ends = null;
		
		$event = new Event();
		$event->setAttributes(array(
	    	'name' => $name,
			'groupId' => $groupId,
			'starts' => $starts,
			'ends' => $ends    
	    ));
	    
	    $this->assertNull($event->name, 'unsaved event has a name');
	    $this->assertNull($event->starts, 'unsaved event has a starts');
	    $this->assertNull($event->ends, 'unsaved event has a ends');
	    $this->assertNull($event->groupId, 'unsaved event has a groupid');
	}

	/**
	 * Test event create when no groupid is set
	 */
	public function testCreateEventNoGroupID() {

		$name = "Test Name";
		$groupId = null;
		$starts = "12/12/12 12:00:00";
		$ends = "12/12/12 12:00:00";
		
		$event = new Event();
		$event->setAttributes(array(
	    	'name' => $name,
			'groupId' => $groupId,
			'starts' => $starts,
			'ends' => $ends    
	    ));
	    
	    $this->assertNull($event->groupId, 'unsaved event has a groupid');
	}
	
	/**
	 * Test event create when no starts is set
	 */
	
	public function testCreateEventNoStarts() {

		$name = "Test Name";
		$groupId = $this->group->id;
		$starts = null;
		$ends = "12/12/12 12:00:00";
		
		$event = new Event();
		$event->setAttributes(array(
	    	'name' => $name,
			'groupId' => $groupId,
			'starts' => $starts,
			'ends' => $ends    
	    ));
	    
	    $this->assertNull($event->starts, 'unsaved event has a start');
	}
	
	/**
	 * Test event create when no ends is set
	 */
	
	public function testCreateEventNoEnds() {

		$name = "Test Name";
		$groupId = $this->group->id;
		$starts = "12/12/12 12:00:00";
		$ends = null;
		
		$event = new Event();
		$event->setAttributes(array(
	    	'name' => $name,
			'groupId' => $groupId,
			'starts' => $starts,
			'ends' => $ends    
	    ));
	    
	    $this->assertNull($event->ends, 'unsaved event has a ends');
	}
	
	/**
	 * Set ends greater than start
	 */
    public function testCreateEventEndsGreaterThanStarts() {
	}
	
	/**
	 * Set starts greater than ends
	 */
    public function testCreateEventStartsGreaterThanEnds() {
	}
	
}
