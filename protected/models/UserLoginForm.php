<?php

Yii::import("application.components.auth.UserIdentity");

Yii::import("application.components.introduction.TutorialActivityGenerator");

/**
 * UserLoginForm class.
 * UserLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserLoginForm extends CFormModel
{
	public $code;

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

		if(is_null($this->_identity))
		{
			$this->_identity = new UserIdentity($this->code);
			$this->_identity->authenticate();
		}
		
		if($this->_identity->errorCode === UserIdentity::ERROR_NONE)
		{
			// FIXME: set duration to match FB expiration value
			$duration = 3600*24*1; // 1 days
			Yii::app()->user->login($this->_identity, $duration);
			//TODO: update last login of user

			$this->afterLogin();

			return true;
		}
		else {
			return false;
		}
	}

	public function afterLogin() {

		// Generate an intro activity for first time users
		if($this->_identity->isNewUser) {
			TutorialActivityGenerator::generateIntroActivity(Yii::app()->user->id);
		}
	}
}
