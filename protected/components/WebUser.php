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
	public function getModel(){
		$user = $this->loadUser(Yii::app()->user->id);
		return $user;
	}

	/**
	 * Load user model.
	 */
	protected function loadUser($id = null)
	{
		if($this->_model === null)
		{
			if($id!==null)
			$this->_model=User::model()->findByPk($id);
		}
		return $this->_model;
	}
	
	/**
	 * @return boolean whether the current application user is a guest.
	 */
	public function getIsAdmin()
	{
		//TODO: implement admin in user
		return $this->getModel()->username == "ajsharma";
	}
}