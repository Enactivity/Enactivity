<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $token
 * @property string $password
 * @property string $firstName
 * @property string $lastName
 * @property string $timeZone
 * @property string $status
 * @property integer $isAdmin
 * @property string $created
 * @property string $modified
 * @property string $lastLogin
 *
 * The followings are the available model relations:
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
	
	const SCENARIO_INSERT = 'insert';
	const SCENARIO_INVITE = 'invite';
	const SCENARIO_PROMOTE_TO_ADMIN = 'promote to admin';
	const SCENARIO_RECOVER_PASSWORD = 'recoverPassword';
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
//			'DateTimeZoneBehavior'=>array(
//				'class' => 'ext.behaviors.DateTimeZoneBehavior',
//			),
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
		array('email', 'required', 'on' => self::SCENARIO_INVITE),
		array('email, token, password, confirmPassword, firstName, lastName, timeZone', 'required', 
			'on' => self::SCENARIO_REGISTER
		),
		array('email, token, password, firstName, lastName, timeZone', 'required',
			'on' => self::SCENARIO_INSERT
		),
		array('email, firstName, lastName, timeZone', 'required', 
			'on' => self::SCENARIO_UPDATE),
			
		array('password, confirmPassword', 'required',
			'on' => self::SCENARIO_REGISTER . ',' . self::SCENARIO_UPDATE_PASSWORD),

		// trim inputs
		array('email', 'filter', 'filter'=>'trim', 'on' => 'invite'),
		array('email, token, firstName, lastName', 'filter', 'filter'=>'trim', 'on' => self::SCENARIO_REGISTER),
		array('email, firstName, lastName', 'filter', 'filter'=>'trim', 'on' => self::SCENARIO_UPDATE),
		
		array('token', 'length', 'max'=>self::TOKEN_MAX_LENGTH),
		
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
			'on' => self::SCENARIO_REGISTER . ',' . self::SCENARIO_UPDATE_PASSWORD),

		array('timeZone', 'default',
			'value'=>'America/Los_Angeles',
			'setOnEmpty'=>true, 'on'=>self::SCENARIO_INVITE
		),
		array(
			'timeZone', 
			'in', 
			'range'=>PDateTime::timeZoneArrayValues()
		),
		
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, email, password, firstName, lastName, status, created, modified, lastLogin', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			
			// all groups that the user is a member of
			'groupUsers' => array(self::HAS_MANY, 'GroupUser', 'userId'),
			'groups' => array(self::HAS_MANY, 'Group', 'groupId',
				'through' => 'groupUsers',
				'order' => 'groups.name'
			),
			'groupsCount' => array(self::STAT, 'Group', 
				'group_user(userId, groupId)',
			),
			
			// all tasks that belong to the groups the user belongs to
			'groupsTasks' => array(self::HAS_MANY, 'Task', 'groupId',
				'through' => 'groups',
			),
			
			// all tasks that the user is actively signed up for
			'taskUsers' => array(self::HAS_MANY, 'TaskUser', 'userId'),

			'tasks' => array(self::HAS_MANY, 'Task', 'taskId', 
				'through' => 'taskUsers',
			),
			
			'nextTasks' => array(self::HAS_MANY, 'Task', 'taskId', 
				'through' => 'taskUsers',
				'condition' => 'taskUsers.isTrash=0 AND taskUsers.isCompleted=0 AND nextTasks.isTrash=0',
			),
			'nextTasksSomeday' => array(self::HAS_MANY, 'Task', 'taskId',
							'through' => 'taskUsers',
							'condition' => 'taskUsers.isTrash=0 AND taskUsers.isCompleted=0 AND nextTasksSomeday.isTrash=0 AND nextTasksSomeday.starts IS NULL',
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'email' => 'Email',
			'token' => 'Token',
			'password' => 'Password',
			'firstName' => 'First name',
			'lastName' => 'Last name',
			'timeZone' => 'Time zone',
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

	/**
	 * Inject a user into the system
	 * @param array $attributes
	 * @return boolean
	 * @see CActiveRecord::save()
	 */
	public function insertUser($attributes = null) {
		$this->scenario = self::SCENARIO_INSERT;
		if($this->isNewRecord) {
			if(is_array($attributes)) {
				$this->attributes = $attributes;
				$this->status = User::STATUS_ACTIVE;
				return $this->save();
			}
			return false;
		}
		throw new CDbException(Yii::t('user','The user could not be injected because it is not new.'));
	}
	
	/**
	 * Invite a new user
	 * @param String email
	 * @return boolean
	 * @throws CDbException if user record is not new
	 */
	public function inviteUser($email) {
		$this->scenario = self::SCENARIO_INVITE;
		if($this->isNewRecord) {
			$attributes = array(
				'email'=>$email,
			);
			$this->attributes = $attributes;
			return $this->save();
		}
		throw new CDbException(Yii::t('user','The user could not be invited because it is not new.'));
	}
	
	/**
	 * Reset the user's password and send an email notifying them of the 
	 * update.
	 * Also sets flash for user.
	 * @return boolean
	 * @throws CDbException if error saving password
	 */
	public function recoverPassword() {
		// set scenario to encrypt on save
		$this->scenario = self::SCENARIO_RECOVER_PASSWORD;
		$newPassword = self::generatePassword(); // store unencrypted for email
		$this->password = $newPassword;
		
		if($this->save()) {
			// email user
			Yii::import('application.extensions.mailer.PasswordEmail');
			$mail = new PasswordEmail;
			$mail->to = $this->email;
			$mail->newpassword = $newPassword;
			$mail->shouldEmail = true;
			Yii::app()->mailer->send($mail);
			
			// notify end user
			Yii::app()->user->setFlash('success', 'We\'ve emailed you your new password.');
			
			return true;
		}
		else {
			$errors = $this->getErrors('password');
			throw new CDbException('There was an error generating a new password.', 
				500, $errors[0]);
		}
	}
	
	/**
	 * Register a pending user, saves.
	 * @param array $attributes
	 * @return boolean
	 * @see CActiveRecord::save()
	 */
	public function registerUser($attributes = null) {
		$this->scenario = self::SCENARIO_REGISTER;
		if(is_array($attributes)) {
			$this->attributes = $attributes;
			$this->status = User::STATUS_ACTIVE;
			return $this->save();
		}
		return false;
	}

	/**
	 * Updates a user's password, saves.
	 * @param array $attributes
	 * @return boolean
	 * @see CActiveRecord::save()
	*/
	public function updatePassword($attributes = null) {
		$this->scenario = self::SCENARIO_UPDATE_PASSWORD;
		if(is_array($attributes)) {
			$this->attributes = $attributes;
			return $this->save();
		}
		return false;
	}
	
	/**
	 * Updates a user's profile, saves.
	 * @param array $attributes
	 * @return boolean
	 * @see CActiveRecord::save()
	*/
	public function updateUser($attributes = null) {
		$this->scenario = self::SCENARIO_UPDATE;
		if(is_array($attributes)) {
			$this->attributes = $attributes;
			return $this->save();
		}
		return false;
	}
	
	/**
	 * Promote the user to admin level
	 * @return boolean
	 * @see CActiveRecord::save();
	 */
	public function promoteToAdmin() {
		$this->scenario = self::SCENARIO_PROMOTE_TO_ADMIN;
		$this->isAdmin = 1;
		return $this->save();
	}
	
	/**
	 * Convert email to lowercase
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			//lowercase unique values
			$this->email = strtolower($this->email);
			return true;
		}
		return false;
	}

	/**
	 * Generate new token on new record.  Encrypt password if needed.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave()) {
			if($this->isNewRecord) {
				//encrypt token and password
				$this->token = self::generateToken();
			}
			if($this->getScenario() == self::SCENARIO_INSERT
				|| $this->getScenario() == self::SCENARIO_REGISTER
				|| $this->getScenario() == self::SCENARIO_RECOVER_PASSWORD	
				|| $this->getScenario() == self::SCENARIO_UPDATE_PASSWORD) {
				$this->password = self::encrypt($this->password, $this->token);
			}
			return true;
		}
		return false;
	}

	public function defaultScope() {
		return array(
			'order' => 'firstName ASC',
		);
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
		if(is_null($value) || empty($value)) {
			throw new CDbException("No value specified in encrypt call");
		}
		if(is_null($token) || empty($token)) {
			throw new CDbException("No token specified in encrypt call");
		}
		
		return sha1(self::SALT . $token . $value);
	}
	
	/**
	 * @return string new encrypted token
	 */
	public static function generateToken() {
		$token = sha1( uniqid() );
		$user = User::model()->findByAttributes(array("token" => $token));
		if(is_null($user)) {
			return $token;
		}
		
		return self::generateToken();
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
	 * @return array of the available statuses
	 */
	public static function getStatuses() {
		return array(self::STATUS_ACTIVE,
			self::STATUS_INACTIVE, 
			self::STATUS_PENDING,
			self::STATUS_BANNED);
	}
	
	/**
	 * Invite a user to the web app
	 * 
	 * @param string userName the name of the user sending the invite
	 * @param string groupName the name of the group
	 * @return boolean true if successfully emailed
	 */
	public function sendInvitation($userName, $groupName) {
		//send invite email
		Yii::import('application.extensions.mailer.InviteEmail');
		$mail = new InviteEmail;
		$mail->to = $this->email;
		$mail->userName = $userName;
		$mail->groupName = $groupName;
		$mail->token = $this->token;
		$mail->shouldEmail = true;
		return Yii::app()->mailer->send($mail);
	}
}