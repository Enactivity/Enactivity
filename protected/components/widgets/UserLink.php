<?php
/**
 * UserLink php class widget file
 */

/**
 * UserLink displays a link to the given user's page with the 
 * text value matching their full name (or email if no name is available);
 * @author Ajay Sharma
 */
class UserLink extends CWidget {
	
	/**
	 * @var CModel model
	 */
	public $userModel;
	
	/**
	 * This method is called by CController::beginWidget()
	 */
	public function init()
	{
	}
 
	public function run()
	{
		// this method is called by CController::endWidget()
		$this->renderLink();
	}
	
	protected function renderLink() {
		if(isset($this->userModel)) {
// 			echo PHtml::link(
// 				PHtml::encode($this->userModel->fullName != "" ? $this->userModel->fullName : $this->userModel->email), 
// 				$this->userModel->permalink, 
// 				array(
// 					'class'=>'userlink',
// 				)
// 			);
			echo PHtml::encode($this->userModel->fullName != "" ? $this->userModel->fullName : $this->userModel->email);
		}
		else {
			echo 'Deleted user account';
		}
	}
}