<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $token
 * @property string $password
 * @property string $firstName
 * @property string $lastName
 * @property string $status
 * @property string $created
 * @property string $modified
 * @property string $lastLogin
 *
 * The followings are the available model relations:
 * @property Event[] $events
 * @property EventUser[] $eventUsers
 * @property GroupUser[] $groupUsers
 * @property Group[] $groups
 */
class User extends CActiveRecord
{
	const EMAIL_MAX_LENGTH = 50;
	const EMAIL_MIN_LENGTH = 3;
	
	const FIRSTNAME_MAX_LENGTH = 50;
	const FIRSTNAME_MIN_LENGTH = 2;
	
	const PASSWORD_MAX_LENGTH = 40;
	const PASSWORD_MIN_LENGTH = 4;
	
	const LASTNAME_MAX_LENGTH = 50;
	const LASTNAME_MIN_LENGTH = 2;
	
	const TOKEN_MAX_LENGTH = 40;
	
	const STATUS_PENDING = 'Pending';
	const STATUS_ACTIVE = 'Active';
	const STATUS_INACTIVE = 'Inactive';
	const STATUS_BANNED = 'Banned';
	const STATUS_MAX_LENGTH = 15;
	
	const USERNAME_MAX_LENGTH = 50;
	const USERNAME_MIN_LENGTH = 3;
	
	const SCENARIO_INVITE = 'invite';
	const SCENARIO_REGISTER = 'register';
	const SCENARIO_UPDATE = 'update';
	const SCENARIO_UPDATE_PASSWORD = 'updatePassword';

	/******************************************************
	 * DO NOT CHANGE THE SALT!  YOU WILL BREAK ALL SIGN-INS
	 ******************************************************/
	const SALT = 'yom0mm4wasap455w0rd';

	/**
	 * @var string
	 */
	public $confirmPassword;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}
	
	/**
	 * @return array behaviors that this model should behave as
	 */
	public function behaviors() {
		return array(
			// Update created and modified dates on before save events
			'CTimestampBehavior'=>array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'created',
				'updateAttribute' => 'modified',
				'setUpdateOnCreate' => true,
			),
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('email', 'required', 'on' => 'invite'),
		array('email, token, username, password, confirmPassword, firstName, lastName', 'required', 
			'on' => 'register'),
		array('email, username, firstName, lastName', 'required', 
			'on' => 'update'),
		array('password, confirmPassword', 'required',
			'on' => 'updatePassword'),

		array('token', 'length', 'max'=>self::TOKEN_MAX_LENGTH),
		
		array('username', 'unique', 
			'allowEmpty' => false, 
			'caseSensitive'=>false,
			'on' => 'register, update'),
		array('username', 'length', 
			'min'=>self::USERNAME_MIN_LENGTH,
			'max'=>self::USERNAME_MAX_LENGTH,
			'on' => 'register, update'),
		array('username', 'match', 
			'allowEmpty' => false, 
			'pattern' => '/^[a-zA-Z][a-zA-Z0-9_]*\.?[a-zA-Z0-9_]*$/',
			'on' => 'register, update'),
		array('email', 'unique', 
			'allowEmpty' => false, 
			'caseSensitive'=>false),
		array('email', 'length', 
			'min'=>self::EMAIL_MIN_LENGTH, 
			'max'=>self::EMAIL_MAX_LENGTH),
		array('email', 'email'),

		array('firstName', 'length', 
			'min'=>self::FIRSTNAME_MIN_LENGTH, 
			'max'=>self::FIRSTNAME_MAX_LENGTH),
		array('lastName', 'length', 
			'min'=>self::LASTNAME_MIN_LENGTH, 
			'max'=>self::LASTNAME_MAX_LENGTH),
		array('firstName, lastName', 'match', 
			'allowEmpty' => false, 
			'pattern' => '/^[a-zA-Z]*$/'),
			
		array('password', 
			'length', 
			'min'=>self::PASSWORD_MIN_LENGTH, 
			'max'=>self::PASSWORD_MAX_LENGTH),
		
		array('confirmPassword', 'compare', 
			'compareAttribute'=>'password', 
			'message' => 'Passwords do not match',
			'on' => 'register, updatePassword'),

		array('status', 'length', 
			'max'=>self::STATUS_MAX_LENGTH),
		array('status', 'default',
			'value'=>self::STATUS_PENDING,
			'setOnEmpty'=>false, 'on'=>'invite'
		),
		array('status', 'in', 'range'=>array(
			self::STATUS_PENDING,
			self::STATUS_ACTIVE,
			self::STATUS_INACTIVE
			)
		),
		
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, username, email, password, firstName, lastName, status, created, modified, lastLogin', 'safe', 'on'=>'search'),
		);
		//FIXME: users can use restricted words for username
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'createdEvents' => array(self::HAS_MANY, 'Event', 'creatorId'),
		
			'events' => array(self::MANY_MANY, 'Event', 
				'event_user(userId, eventId)'),
			'eventUsers' => array(self::HAS_MANY, 'EventUser', 'userId'),
			
			'groups' => array(self::MANY_MANY, 'Group', 
				'group_user(userId, groupId)',
				'order' => 'groups.name'),
			'groupUsers' => array(self::HAS_MANY, 'GroupUser', 'userId'),
		);
		//TODO: stats: # future events 
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'email' => 'Email',
			'token' => 'Token',
			'password' => 'Password',
			'firstName' => 'First name',
			'lastName' => 'Last name',
			'status' => 'Status',
			'created' => 'Created',
			'modified' => 'Last modified',
			'lastLogin' => 'Last login',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('firstName',$this->firstName,true);
		$criteria->compare('lastName',$this->lastName,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('lastLogin',$this->lastLogin,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function defaultScope() {
		return array(
			'order' => 'firstName ASC',
		);
	}

	/**
	 * Convert email and username to lowercase
	 * 
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			//lowercase unique values
			$this->email = strtolower($this->email);
			if(isset($this->username)) { //to prevent nulls turning into ""
				$this->username = strtolower($this->username);	
			}
			return true;
		}
		return false;
	}

	/**
	 * Generate new token on new record.  Encrypt password if needed.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{				
				//encrypt token and password
				$this->token = self::generateToken();
			}
			elseif($this->getScenario() == self::SCENARIO_REGISTER
				|| $this->getScenario() == self::SCENARIO_UPDATE_PASSWORD) {
				$this->password = self::encrypt($this->password, $this->token);
			}
			return true;
		}
		return false;
	}

	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function isPassword($password)
	{
		return self::encrypt($password, $this->token) === $this->password;
	}
	
	/**
	 * Checks if the user has the given status
	 * @param string the status to check
	 * @return boolean whether the user is of the given status
	 */
	public function isStatus($status)
	{
		return $this->status === $status;
	}
	
	/**
	 * Is the user's status 'Active'?
	 * @return boolean whether the user is active
	 */
	public function getIsActive() {
		return $this->isStatus(self::STATUS_ACTIVE);
	}
	
/**
	 * Is the user's status 'Banned'?
	 * @return boolean whether the user is banned
	 */
	public function getIsBanned() {
		return $this->isStatus(self::STATUS_BANNED);
	}

	/**
	 * Encrypt the given value
	 * @param string $value
	 * @param string $token
	 * @return string encrypted value
	 */
	public static function encrypt($value, $token) {
		return sha1(self::SALT . $token . $value);
	}
	
	/**
	 * @return string new encrypted token
	 */
	public static function generateToken() {
		return self::encrypt(time(), '');
	}
	
	/**
	 * @return string a new random password
	 */
	public static function generatePassword() {
		return StringUtils::createRandomString(10);
	}

	/**
	 * Get the full name of the user (i.e. First Last)
	 * @return string FirstName LastName or NULL if neither is set
	 */
	public function getFullName() {
		if($this->firstName != NULL 
		&& $this->lastName != NULL) {
			return $this->firstName . ' ' . $this->lastName;
		}
		else {
			return NULL;
		}
	}
	
	/**
	 * Get the url for viewing this user
	 * @return string url to user page
	 */
	public function getPermalink()
	{
		return Yii::app()->request->hostInfo .
			Yii::app()->createUrl('user/view', 
			array(
            	'id'=>$this->id,
            	'username'=>$this->username,
			)
		);
	}
	
	/**
	 * @return array of the available statuses
	 */
	public static function getStatuses() {
		return array(self::STATUS_ACTIVE,
			self::STATUS_INACTIVE, 
			self::STATUS_PENDING,
			self::STATUS_BANNED);
	}
	
	/**
	 * Find a user by their username or email
	 * @param string $usernameOrEmail
	 * @return CActiveRecord the record of the user if found. Null if no record is found. 
	 */
	public static function findByUsernameOrEmail($usernameOrEmail) {
		$usernameOrEmail = strtolower($usernameOrEmail);	
		
		if(strpos($usernameOrEmail, '@')) { //user inputted email
			$criteria = new CDbCriteria();
			$criteria->addCondition('LOWER(email) = :usernameOrEmail');
			$criteria->params[':usernameOrEmail'] = $usernameOrEmail;
			return $user = User::model()->find($criteria);	
		}		
		else {// user did not input email, assume username
			$criteria = new CDbCriteria();
			$criteria->addCondition('LOWER(username) = :usernameOrEmail');
			$criteria->params[':usernameOrEmail'] = $usernameOrEmail;
			return $user = User::model()->find($criteria);	
		}
	}
	
	/**
	 * Invite a user to the web app
	 * @param string userName the name of the user sending the invite
	 * @param string groupName the name of the group
	 * @return void
	 */
	public function sendInvitation($userName, $groupName) {
		//send invite email
		$from = "no-reply@poncla.com";
		$subject = "{$userName} invites you to join {$groupName} on Poncla";
		$body = $userName . " has invited you to join the {$groupName} group on"
		. " Poncla. To accept this invitation, go to "
		. Yii::app()->request->hostInfo . "/index.php/user/register?token=" . $this->token 
		. " and complete your registration.";
		
		$headers = 'From: no-reply@poncla.com';
		mail($this->email, $subject, $body, $headers);
	}
	
	/**
	 * Reset the user's password and send an email notifying them of the 
	 * update.
	 * Also sets flash for user.
	 * @return void
	 */
	public function recoverPassword() {
		$newpassword = self::generatePassword();
		$this->password = $newpassword;
		if($this->save()) {
			// email user
			$from = 'no-reply@poncla.com';
			$subject = 'Your Poncla password has been reset';
			$body = 'Someone has requested that your password for your account'
			. ' be reset.  We\'ve generated the new password: ' . $newpassword
			. ' for you.  You can change it once you log in.  If you didn\'t request'
			. ' this new password please contact us at info@poncla.com';
			
			$headers = 'From: no-reply@poncla.com';
			mail($this->email, $subject, $body, $headers);
			
			// notify end user
			Yii::app()->user->setFlash('success', 'We\'ve emailed you your new password.');
		}
		else {
			$errors = $this->getErrors('password');
			throw new CDbException('There was an error generating a new password.', 
				500, $errors[0]);
		}
	}
}