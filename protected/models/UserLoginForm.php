<?php

/**
 * UserLoginForm class.
 * UserLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserLoginForm extends CFormModel
{
	/**
	 * @var string
	 */
	public $email;
	
	/**
	 * @var string
	 */
	public $password;
	
	/**
	 * @var boolean
	 */
	public $rememberMe;

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
		// email and password are required
		array('email, password', 'required'),
		array('email', 'email'),
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
	 * @return void
	 */
	public function authenticate($attribute, $params)
	{
		// attempt to sign in
		$identity = new UserIdentity($this->email, $this->password);
		if($identity->authenticate()) {
			return;
		}
		
		switch($identity->errorCode)
		{
			case UserIdentity::ERROR_USERNAME_INVALID:
			case UserIdentity::ERROR_PASSWORD_INVALID:
				$this->addError('email', Yii::t('', 'No user found with that email and password.'));
				break;
			case UserIdentity::ERROR_STATUS_NOT_ACTIVE:
				$this->addError('status', Yii::t('', 'Your account has not been activated.  Please register first.'));
				break;
			case UserIdentity::ERROR_STATUS_BANNED:
				$this->addError('status', Yii::t('', 'Your account has been banned.'));
				break;
			default:
				throw new CHttpException(500, 'Something broke when you tried to login.  Please try again');
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
