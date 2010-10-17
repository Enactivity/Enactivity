<?php

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
}