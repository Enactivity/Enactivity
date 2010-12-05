<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $email;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
		// email and password are required
		array('email, password', 'required'),
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
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
//	public function authenticate($attribute, $params)
//	{
//		$this->_identity = new UserIdentity($this->email, $this->password);
//		if(!$this->_identity->authenticate()) {
//			$this->addError('password', 'Incorrect email or password.');
//		}
//	}
	
	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute, $params)
	{
		if(!$this->hasErrors())  // we only want to authenticate when no input errors
		{
			$identity=new UserIdentity($this->email,$this->password);
			$identity->authenticate();
			switch($identity->errorCode)
			{
				case UserIdentity::ERROR_NONE:
					Yii::app()->user->login($identity, $duration);
					break;
				case UserIdentity::ERROR_EMAIL_INVALID:
				case UserIdentity::ERROR_PASSWORD_INVALID:
					$this->addError('email', Yii::t('', 'Incorrect email or password.'));
					break;
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError('email', Yii::t('', 'Incorrect username or password.'));
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
	 * Logs in the user using the given email and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity === null)
		{
			$this->_identity = new UserIdentity($this->email, $this->password);
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
