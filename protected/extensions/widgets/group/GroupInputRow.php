<?php
/**
 * GroupInputRow class file
 * @author Ajay Sharma
 */

/**
 * GroupInputRow displays an input field matching the user's  
 * @author Ajay Sharma
 *
 */
class GroupInputRow extends CWidget {
	
	/**
	 * @var boolean should all the groups be show when the user is an admin
	 */
	public $showAllGroupsOnAdmin = true;
	
	private $groups;
	
	/**
	 * This method is called by CController::beginWidget()
	 */
	public function init()
	{
		// get user's groups
		if(Yii::app()->user->isAdmin) {
			$groups = Group::model()->findAll();
		}
		else {
			$groups = Yii::app()->user->model->groups;	
		}
	}
 
	public function run()
	{
		// this method is called by CController::endWidget()
		$this->renderRow($this->$groups);
	}
}