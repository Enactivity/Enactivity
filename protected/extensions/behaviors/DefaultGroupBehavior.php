<?php
/**
 * DefaultGroupBehavior class file.
 *
 * @author Ajay Sharma
 */
 
/**
 * DefaultGroupBehavior will automatically set the model's groupId value to
 * match the user's group if the user is a member of only one group.
 * @author Ajay Sharma
 */

class DefaultGroupBehavior extends CActiveRecordBehavior {
	
	/**
	 * @var string The name of the attribute to store the group Id.
	 */
	public $groupId = 'groupId';
	
	/**
	 * Responds to {@link CModel::onBeforeValidate} event.
	 * Sets the values of the group id attributes as configured
	 * 
	 * @param CModelEvent event parameter
	 */
	public function beforeValidate($event) {
		if ($this->getOwner()->getIsNewRecord() && ($this->getOwner()->groupId == null)) {
			$this->getOwner()->{$this->groupId} = $this->getUserGroupId();
		}
	}
	
	/**
	 * Returns the current user's single group, if the user
	 * belongs to more than one group, and exception is thrown.
	 * 
	 * @return int id
	 */
	protected function getUserGroupId() {
		if(Yii::app()->user->model->groupsCount == 1) {
			return Yii::app()->user->model->groups[0]->id;
		}
		throw new Exception("Error when attempting to set user group."
			. " User is a member of [" 
			. Yii::app()->user->model->groupsCount 
			. "] groups.");
	}
}