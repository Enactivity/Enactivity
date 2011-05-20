<?php
/**
 * Task Participate class file
 * @author Ajay Sharma
 */

/**
 * Participate displays an input field matching the user's  
 * @author Ajay Sharma
 */
class Participate extends CWidget {
	
	/**
	 * @var CModel model
	 */
	public $model = null;
	
	/**
	 * This method is called by CController::beginWidget()
	 */
	public function init()
	{
		if(is_null($this->task)) {
			throw exception ("No task passed into ParticipateButton");
		}
	}
 
	public function run()
	{
		$this->render();
	}
	
	protected function render() {
	}
}