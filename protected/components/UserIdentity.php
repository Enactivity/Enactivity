<?php
class UserIdentity extends CUserIdentity
{
	private $_id;

	public function authenticate()
	{
		$username = strtolower($this->username);
		$user = User::model()->find('LOWER(username) = ?', array($username));
		if($user === null) //user does not exist
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		else if($user->validatePassword($this->password)) //valid log in
		{ 	// TODO: check user status, re-activate inactive user
			$this->_id = $user->id;
			$this->username = $user->username;
			$this->errorCode = self::ERROR_NONE;
		}
		else //user exists, but invalid log in attempt
		{
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
		return $this->errorCode == self::ERROR_NONE;
	}

	public function getId()
	{
		return $this->_id;
	}
}