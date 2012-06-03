<?php
/**
 * Abstract Button Widget class file
 * @author Ajay Sharma
 */

/**
 * Provides an abstraction layer for creating buttons  
 * @author Ajay Sharma
 */
abstract class ButtonWidget extends CWidget {
	
	/**
	 * Task model
	 * @var Task model
	 */
	public $task = null;
	
	/**
	 * Should show widget
	 * @var boolean
	 */
	public $visible = true;
	
	/**
	 * @override
	 */
	public function init()
	{
		if(is_null($this->task)) {
			throw exception ("No task passed into button widget");
		}
	}
 
	/**
	 * @override
	 */
	public function run()
	{
		if($this->visible) {
			$this->renderButton();
		}
	}
	
	/**
	 * Renders the html for the button
	 */
	abstract protected function renderButton();
}