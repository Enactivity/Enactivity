<?php
/**
 * UserIdentity represents the data needed to identify a user.
 * @author Ajay Sharma
 *
 */
class UserIdentity extends CUserIdentity
{
	// Additional error codes to CBaseUserIdentity
	const ERROR_STATUS_NOT_ACTIVE=3;
	const ERROR_STATUS_BANNED=4;
	const ERROR_STATUS_INVALID_FACEBOOK_ID=5;
	
	private $_id;

	private $_code;
	private $_access_token;

	public function __construct($code) {
		$this->_code = $code;
	}

	
	/**
	 * Authenticates a user based on {@link username} (which is actually
	 * an email) and {@link password}.
	 * This method is required by {@link IUserIdentity}.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$facebookId = Yii::app()->FB->facebookUserId;

		if($facebookId) {
			$user = User::model()->findByAttributes(
				array(
					'facebookId' => $facebookId,
				)
			);

			if(is_null($user)) { // user does not exist
				// Create a new user
				$user = User::register(array());
			}

			// check user status, re-activate inactive user
			if($user->isBanned) {
				$this->errorCode = self::ERROR_STATUS_BANNED;
			}
			else if($user->isActive) {
				// Set useful current user values  
				$this->_id = $user->id;
				$this->errorCode = self::ERROR_NONE;
			}
			else {
				$this->errorCode = self::ERROR_STATUS_NOT_ACTIVE;
			}
		}
		else {
			$this->errorCode = self::ERROR_STATUS_INVALID_FACEBOOK_ID;
		}

		return $this->errorCode == self::ERROR_NONE;
	}

	public function getId()
	{
		return $this->_id;
	}
}