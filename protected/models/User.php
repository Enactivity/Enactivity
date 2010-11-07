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
	const STATUS_PENDING = 'Pending';
	const STATUS_ACTIVE = 'Active';
	const STATUS_INACTIVE = 'Inactive';

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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('email', 'required', 'on' => 'invite, create'),
		array('username, password, firstName, lastName', 'required', 'on' => 'create, update'),

		array('username', 'length', 'min'=>3, 'max'=>50),
		array('username, email', 'unique', 'allowEmpty' => true, 
			'caseSensitive'=>false),

		array('email', 'length', 'min'=>3, 'max'=>50),
		array('email', 'email'),

		array('firstName, lastName', 'length', 'min'=>2, 'max'=>50),
			
		array('password', 'length', 'min'=>4, 'max'=>40),

		array('status', 'length', 'max'=>15),
		array('status', 'default',
		 'value'=>self::STATUS_PENDING,
		 'setOnEmpty'=>false, 'on'=>'insert'),
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
				'group_user(userId, groupId)'),
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

	protected function afterValidate() {
		if(parent::afterValidate()) {
			return true;
		}
		return false;
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->created = new CDbExpression('NOW()');
				$this->modified = new CDbExpression('NOW()');
				
				//encrypt token and password
				$this->token = $this->encrypt(time());
				$this->password = $this->encrypt($this->password);
			}
			else {
				//TODO: move to controller so login updates won't change it
				$this->modified = new CDbExpression('NOW()');
			}
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return $this->encrypt($password, $this->token) === $this->password;
	}

	/**
	 * Encrypt the given value
	 * @param string $value
	 * @param string $token
	 * @return encrypted value
	 */
	public function encrypt($value, $token = '') {
		return sha1(self::SALT . $token . $value);
	}

	/**
	 * Get the full name of the user (i.e. First Last)
	 * @return String FirstName LastName or NULL if neither is set
	 */
	public function fullName() {
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
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('user/view', array(
            'id'=>$this->id,
            'username'=>$this->username,
		));
	}
	
	/**
	 * Return a list of the available statuses
	 */
	public static function getStatuses() {
		return array(self::STATUS_ACTIVE,
			self::STATUS_INACTIVE, 
			self::STATUS_PENDING);
	}
}