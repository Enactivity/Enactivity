<?php

/**
 * UserLoginForm class.
 * UserLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserLoginForm extends CFormModel
{
	public $usernameOrEmail;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that usernameOrEmail and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
		// usernameOrEmail and password are required
		array('usernameOrEmail, password', 'required'),
		// rememberMe needs to be a boolean
		array('rememberMe', 'boolean'),
		// password needs to be authenticated
		array('password', 'authenticate', 'skipOnError'=>true),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me',
			'usernameOrEmail'=>'Email',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute, $params)
	{
		if(!$this->hasErrors())  // we only want to authenticate when no input errors
		{
			$identity=new UserIdentity($this->usernameOrEmail, $this->password);
			$identity->authenticate();
			switch($identity->errorCode)
			{
				case UserIdentity::ERROR_NONE:
					Yii::app()->user->login($identity, $duration);
					break;
				case UserIdentity::ERROR_EMAIL_INVALID:
				case UserIdentity::ERROR_PASSWORD_INVALID:
					$this->addError('usernameOrEmail', Yii::t('', 'Incorrect usernameOrEmail or password.'));
					break;
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError('usernameOrEmail', Yii::t('', 'Incorrect username or password.'));
					break;
				case UserIdentity::ERROR_STATUS_NOT_ACTIVE:
					$this->addError('status', Yii::t('', 'Your account has not been activated.  Please register first.'));
					break;
				case UserIdentity::ERROR_STATUS_BANNED:
					$this->addError('status', Yii::t('', 'Your account has been banned.'));
					break;
			}
		}
	}

	/**
	 * Logs in the user using the given usernameOrEmail and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity === null)
		{
			$this->_identity = new UserIdentity($this->usernameOrEmail, $this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode === UserIdentity::ERROR_NONE)
		{
			$duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity, $duration);
			//TODO: update last login of user
			return true;
		}
		else {
			return false;
		}
	}
}
