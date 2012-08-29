<?php

/**
 * UserLoginForm class.
 * UserLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserLoginForm extends CFormModel
{
	public $code;
	public $state;

	/**
	 * @var UserIdentity
	 */
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('code', 'safe'),
		);
	}

	/**
	 * Logs in the user using the given email and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login($attributes)
	{
		$this->attributes = $attributes;

		if($this->_identity === null)
		{
			$this->_identity = new UserIdentity($this->code);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode === UserIdentity::ERROR_NONE)
		{
			//$duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
			$duration = 3600*24*30; // 30 days
			Yii::app()->user->login($this->_identity, $duration);
			//TODO: update last login of user
			return true;
		}
		else {
			return false;
		}
	}
}
