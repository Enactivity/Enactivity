<?php

Yii::import("application.components.db.ar.ActiveRecord");

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email user configurable
 * @property string $token
 * @property string $firstName user configurable
 * @property string $lastName user configurable
 * @property string $timeZone user configurable
 * @property string $status
 * @property string $facebookId
 * @property integer $isAdmin admin configurable
 * @property string $created
 * @property string $modified
 * @property string $lastLogin
 *
 * The followings are the available model relations:
 * @property GroupUser[] $groupUsers
 * @property Group[] $groups
 */
class User extends ActiveRecord
{
	const EMAIL_MAX_LENGTH = 50;
	const EMAIL_MIN_LENGTH = 3;

	const FIRSTNAME_MAX_LENGTH = 50;
	const FIRSTNAME_MIN_LENGTH = 2;

	const LASTNAME_MAX_LENGTH = 50;
	const LASTNAME_MIN_LENGTH = 2;

	const PHONENUMBER_MAX_LENGTH = 20;
	
	const TOKEN_MAX_LENGTH = 40;

	const STATUS_PENDING = 'Pending';
	const STATUS_ACTIVE = 'Active';
	const STATUS_INACTIVE = 'Inactive';
	const STATUS_BANNED = 'Banned';
	const STATUS_MAX_LENGTH = 15;

	const SCENARIO_CHECKOUT = 'checkout';
	const SCENARIO_INSERT = 'insert';
	const SCENARIO_PROMOTE_TO_ADMIN = 'promote to admin';
	const SCENARIO_UPDATE = 'update';

	/******************************************************
	 * DO NOT CHANGE THE SALT!  YOU WILL BREAK ALL SIGN-INS
	******************************************************/
	const SALT = 'yom0mm4wasap455w0rd';

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
		
		// SCENARIO_CHECKOUT
		array('phoneNumber', 'required',
			'on' => self::SCENARIO_CHECKOUT
		),
		
		// SCENARIO_INSERT
		array('email, firstName, lastName, timeZone, facebookId', 'required',
				'on' => self::SCENARIO_INSERT
		),

		// SCENARIO_PROMOTE_TO_ADMIN has no rules

		// SCENARIO_UPDATE
		array('email, firstName, lastName, timeZone', 'required',
				'on' => self::SCENARIO_UPDATE
		),

		// trim inputs
		array('email, firstName, lastName',
				'filter', 
				'filter'=>'trim',
		),

		// email formatting
		array('email',
				'unique', 
				'allowEmpty' => false, 
				'caseSensitive'=>false),
		array('email',
				'length', 
				'min'=>self::EMAIL_MIN_LENGTH, 
				'max'=>self::EMAIL_MAX_LENGTH),
		array('email', 'email'),

		// first and last name lengths & alpha numeric
		array('firstName',
				'length', 
				'min'=>self::FIRSTNAME_MIN_LENGTH, 
				'max'=>self::FIRSTNAME_MAX_LENGTH),
		array('lastName',
				'length', 
				'min'=>self::LASTNAME_MIN_LENGTH, 
				'max'=>self::LASTNAME_MAX_LENGTH),
		array('firstName, lastName',
				'match', 
				'allowEmpty' => false, 
				'pattern' => '/^[a-zA-Z]*$/'),

		// timeZone
		array('timeZone',
				'default',
				'value'=>'America/Los_Angeles',
				'setOnEmpty'=>true, 
		),
		array('timeZone',
				'in', 
				'range'=>PDateTime::timeZoneArrayValues(),
		),
			
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, email, firstName, lastName, status, created, modified, lastLogin', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// stupid hacky way of escaping statuses
		$taskUserNextStatusWhereIn = '\'' . implode('\', \'', TaskUser::getNextableStatuses()) . '\'';

		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below
		return array(
			
			// all cart items the user
			'cartItems' => array(self::HAS_MANY, 'CartItem', 'userId', 
				'condition' => 'purchased IS NULL',
			),
			'cartItemsInProcess' => array(self::HAS_MANY, 'CartItem', 'userId',
				'condition' => 'purchased IS NOT NULL AND delivered IS NULL',
			),
			'cartItemsCompleted' => array(self::HAS_MANY, 'CartItem', 'userId',
				'condition' => 'purchased IS NOT NULL AND delivered IS NOT NULL',
			),
		
			'groupUsers' => array(self::HAS_MANY, 'GroupUser', 'userId',
				'condition' => 'groupUsers.status = "' . GroupUser::STATUS_ACTIVE . '"',
			),
			'allGroupUsers' => array(self::HAS_MANY, 'GroupUser', 'userId'),
		
			'groups' => array(self::HAS_MANY, 'Group', 'groupId',
				'condition' => 'groupUsers.status = "' . GroupUser::STATUS_ACTIVE . '"', //FIXME: needs fix from Yii to use through condition
				'through' => 'groupUsers',
				'order' => 'groups.name',
			),

			'allGroups'  => array(self::HAS_MANY, 'Group', 'groupId',
				'through' => 'allGroupUsers',
				'order' => 'allGroups.name',
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
				'condition' => 'taskUsers.status IN (' . $taskUserNextStatusWhereIn . ')',
			),
			'nextTasksSomeday' => array(self::HAS_MANY, 'Task', 'taskId',
				'through' => 'taskUsers',
				'condition' => 'taskUsers.status IN (' . $taskUserNextStatusWhereIn . ')'
					. ' AND nextTasksSomeday.starts IS NULL',
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
	 * Get the checkout/sales specific information about the user
	 * @param array $attributes
	 */
	public function updateCheckOutInfo($attributes = null) {
		$this->scenario = self::SCENARIO_CHECKOUT;
		if(!$this->isNewRecord) {
			if(is_array($attributes)) {
				$this->attributes = $attributes;
				return $this->save();
			}
			return false;
		}
		throw new CDbException(Yii::t('user','The user checkout information could not be updated because it is a new user.'));
	}

	/**
	 * Inject a user into the system
	 * @param array $attributes
	 * @return boolean
	 * @see ActiveRecord::save()
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
	 * Find a user by their facebook Id
	 * @return User|null
	 * @see User::findByAttributes
	 **/
	public static function findByFacebookId($facebookId) {
		return User::model()->findByAttributes(array(
				'facebookId' => $facebookId,
			)
		);
	}

	/**
	 * Register a new user with us
	 * @return User
	 * @throws CDbException if save fails
	 **/
	public static function register($attributes = array()) {
		$user = new User();

		$user->syncFacebook();
		$user->attributes = $attributes;
		$user->status = User::STATUS_ACTIVE;
		
		if($user->save()) {
			$user->importFacebookGroups();
			return $user;	
		}
		throw new CDbException("User could not be registered: " . CVarDumper::dumpAsString($user->errors));
		
	}

	/**
	 * Set the user's attributes to the values from Facebook
	 * @return User unsaved user
	 **/
	public function syncFacebook() {
		$details = Yii::app()->FB->currentUserDetails;
		$this->attributes = array(
			'facebookId' => $details['id'],
			'firstName'  => $details['first_name'],
			'lastName'   => $details['last_name'],
			'email'		 => $details['email'],
			'timeZone' 	 => PDateTime::timeZoneByOffset($details['timezone']) ? PDateTime::timeZoneByOffset($details['timezone']) : 'America/Los_Angeles',
		);
		return $this;
	}

	/**
	 * Set the user's group memberships to match their list in Facebook
	 * @return boolean
	 **/
	public function syncFacebookGroups() {

		$syncedGroups = array();
		$facebookGroups = Yii::app()->FB->currentUserGroups;
		
		foreach($facebookGroups['data'] as $group) {
			$group = Group::syncWithFacebookAttributes($group);
			$group->syncFacebookMembers();
			$syncedGroups[$group->id] = true;
		}

		// Remove user from remaining groups
		foreach($this->allGroups as $group) {
			if(!isset($syncedGroups[$group->id])) {
				GroupUser::saveAsDeactiveMember($group->id, $this->id);
			}
		}

		return true;
	}

	/** 
	 * Pull the user's group memberships from Facebook.
	 * Does not delete old groups.  Useful for initial import of user info.
	 * @return boolean
	 **/
	public function importFacebookGroups() {
		$syncedGroups = array();
		$facebookGroups = Yii::app()->FB->currentUserGroups;
		
		foreach($facebookGroups['data'] as $group) {
			$group = Group::syncWithFacebookAttributes($group);
			$syncedGroups[$group->id] = true;
		}

		return true;
	}

	/**
	 * Updates a user's profile, saves.
	 * @param array $attributes
	 * @return boolean
	 * @see ActiveRecord::save()
	 */
	public function updateUser($attributes = null) {
		$this->scenario = self::SCENARIO_UPDATE;
		if(!$this->isNewRecord) {
			if(is_array($attributes)) {
				$this->attributes = $attributes;
				return $this->save();
			}
			return false;
		}
		throw new CDbException(Yii::t('user','The user could not be updated because it is new.'));
	}

	/**
	 * Promote the user to admin level
	 * @return boolean
	 * @see ActiveRecord::save();
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
				$this->token = self::generateToken();
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
	 * Checks if the user has the given status
	 * @param string the status to check
	 * @return boolean whether the user is of the given status
	 */
	public function isStatus($status)
	{
		return $this->status === $status;
	}

	/**
	 * Is the user's status 'Pending'?
	 * @return boolean whether the user is pending
	 */
	public function getIsPending() {
		return $this->isStatus(self::STATUS_PENDING);
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
	 * Has the user registered yet?
	 * @return boolean
	 */
	public function getIsRegistered() {
		return $this->isActive || $this->isBanned;
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
	 * Get the full name of the user (i.e. First Last)
	 * @return string FirstName LastName or NULL if neither is set
	 */
	public function getFullName() {
		if($this->firstName != NULL
		&& $this->lastName != NULL) {
			return $this->firstName . ' ' . $this->lastName;
		}
		
		return NULL;
	}

	/**
	 * Get the proper name for the user depending on their information available
	 * @return string
	 **/
	public function getNickname() {
		if($this->fullName) {
			return $this->fullName;
		}
		return $this->userModel->email;
	}

	public function getPictureURL() {
		return Yii::app()->FB->getUserPictureURL($this->facebookId);
	}

	public function getGroupsCount() {
		return sizeof($this->groups);
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