<?php
/**
 * GroupInputRow class file
 * @author Ajay Sharma
 */

/**
 * GroupInputRow displays an input field matching the user's  
 * @author Ajay Sharma
 */
class GroupInputRow extends CWidget {
	
	/**
	 * @var boolean should all the groups be show when the user is an admin
	 */
	public $showAllGroupsOnAdmin = false;
	
	/**
	 * @var CActiveForm widget
	 */
	public $form = null;
	
	/**
	 * @var CModel model
	 */
	public $model = null;
	
	/**
	 * @var User's groups
	 */
	public $groups = array();
	
	/**
	 * This method is called by CController::beginWidget()
	 */
	public function init()
	{
		// get user's groups
		if($this->showAllGroupsOnAdmin && Yii::app()->user->isAdmin) {
			$this->groups = Group::model()->findAll();
		}
	}
 
	public function run()
	{
		// this method is called by CController::endWidget()
		$this->renderRow();
	}
	
	protected function renderRow() {
		if(count($this->groups) != 1) {
			echo CHtml::openTag('div', array('class' => 'row'));
			
			echo CHtml::openTag('div', array('class' => 'formlabel'));
			echo $this->form->labelEx($this->model, 'groupId');
			echo CHtml::closeTag('div');
			
			echo CHtml::openTag('div', array('class' => 'forminput'));
			echo $this->form->dropDownList($this->model, 'groupId', 
					PHtml::listData($this->groups, 'id', 'name'));
			echo CHtml::closeTag('div');
			
			echo CHtml::openTag('div', array('class' => 'formerrors'));
			echo $this->form->error($this->model,'groupId');
			echo CHtml::closeTag('div');
			
			echo CHtml::closeTag('div');
		}
	}
}