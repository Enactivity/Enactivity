<?php
/**
 * Overrides CWebUser to provide access to the User model
 * @author Ajay Sharma
 *
 */
class WebUser extends CWebUser {

	/**
	 * Store model to not repeat query.
	 */
	private $_model;

	/**
	 * Return the model, access it by <code>Yii::app()->user->model</code>.
	 * @return User $user
	 */
	public function getModel() {
		$user = $this->loadUser($this->id);
		return $user;
	}

	protected function afterLogout()
	{
		parent::afterLogout();
		Yii::app()->FB->logout();
	}

	/**
	 * Load user model.
	 * @param int id User's id
	 */
	protected function loadUser($id = null) {
		if(is_null($this->_model)
			&& !is_null($id)) {
			$this->_model = User::model()->findByPk($id);
		}

		return $this->_model;
	}

	/**
	 * Returns a value indicating whether the user is authenticated/logged in (not a guest).
	 * @return boolean
	 **/
	public function getIsAuthenticated() {
		return !$this->isGuest;
	}
	
	/**
	 * @return boolean whether the current application user is a guest.
	 */
	public function getIsAdmin() {
		//TODO: implement admin in user
		return isset($this->model->isAdmin) && $this->model->isAdmin;
	}
	
	/**
	 * @param int $groupId
	 * @return boolean whether the current application user is in the group
	 */
	public function isGroupMember($groupId) {
		if(is_null($groupId) || empty($groupId)) {
			return false;
		}
		
		return membership::model()->isGroupMember($groupId, Yii::app()->user->id); 
	}
	
	public function getTimeZone() {
		if(!is_null($this->getModel())) {
			return $this->getModel()->timeZone;
		} 
		else {
			return null;
		}
	}
}