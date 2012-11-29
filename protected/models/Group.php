<?php

Yii::import("application.components.db.ar.ActiveRecord");
Yii::import("application.components.db.ar.EmailableRecord");

/**
 * This is the model class for table "group".
 *
 * The followings are the available columns in table 'group':
 * @property integer $id
 * @property string $name
 * @property string $facebookId
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Membership[] $memberships
 * @property User[] $users
 */
class Group extends ActiveRecord implements EmailableRecord
{
	const NAME_MAX_LENGTH = 255;
	const NAME_MIN_LENGTH = 3;
	
	const FACEBOOKID_MAX_LENGTH = 255;
	const FACEBOOKID_MIN_LENGTH = 3;
	
	const EMAIL_MAX_LENGTH = 50;
	const EMAIL_MIN_LENGTH = 5;
	
	const SCENARIO_INSERT = 'insert';
	const SCENARIO_UPDATE = 'update';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Group the static model class
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
		return 'group';
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
			'DateTimeZoneBehavior'=>array(
				'class' => 'ext.behaviors.DateTimeZoneBehavior',
			),
			// Record C-UD operations to this record
			'EmailNotificationBehavior'=>array(
				'class' => 'ext.behaviors.model.EmailNotificationBehavior',
				'ignoreAttributes' => array('modified', 'starts'),
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
		array('name, facebookId', 'required'),
		array('name', 'length', 'max'=>self::NAME_MAX_LENGTH),
		array('facebookId', 'length', 'max'=>self::FACEBOOKID_MAX_LENGTH),
		
		// trim inputs
		array('name, facebookId', 'filter', 'filter'=>'trim'),
		array('facebookId', 'unique', 
			'allowEmpty' => false, 
			'caseSensitive'=>false
		),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, name, facebookId, created, modified', 'safe', 'on'=>'search'),
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
			'memberships' => array(self::HAS_MANY, 'Membership', 'groupId'),
			'membershipsActive' => array(self::HAS_MANY, 'Membership', 'groupId',
				'condition' => 'status="' . Membership::STATUS_ACTIVE .'"'),
			'membershipsActiveCount' => array(self::STAT, 'Membership', 'groupId', 
				'condition' => 'status="' . Membership::STATUS_ACTIVE .'"'),
			'membershipsPending' => array(self::HAS_MANY, 'Membership', 'groupId',
				'condition' => 'status="' . Membership::STATUS_PENDING .'"'),
			'membershipsPendingCount' => array(self::STAT, 'Membership', 'groupId', 
				'condition' => 'status="' . Membership::STATUS_PENDING .'"'),
			'users' => array(self::HAS_MANY, 'User', 'userId',
		    	'through' => 'memberships',
				'order' => 'users.lastname'
			),
			'usersActive' => array(self::HAS_MANY, 'User', 'userId',
		    	'through' => 'memberships',
				'condition' => 'memberships.status="' . Membership::STATUS_ACTIVE . '"' 
					. ' AND usersActive.status="' . User::STATUS_ACTIVE . '"', 
				'order' => 'usersActive.lastname'
			),
			'usersPending' => array(self::HAS_MANY, 'User', 'userId',
		    	'through' => 'memberships',
				'condition' => 'memberships.status="' . Membership::STATUS_PENDING . '"' 
					. ' AND usersPending.status="' . User::STATUS_ACTIVE . '"', 
				'order' => 'usersPending.lastname'
			),
			'usersInactive' => array(self::HAS_MANY, 'User', 'userId',
		    	'through' => 'memberships',
				'condition' => 'memberships.status="' . Membership::STATUS_INACTIVE . '"' 
					. ' AND usersInactive.status="' . User::STATUS_ACTIVE . '"', 
				'order' => 'usersInactive.lastname'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Group',
			'name' => 'Name',
			'facebookId' => 'Facebook Id',
			'created' => 'Created',
			'modified' => 'Last modified',
			'membershipsActiveCount' => 'Number of Active Users',
			'membershipsPendingCount' => 'Number of Pending Users',
		);
	}

	public function scenarioLabels() {
		return array(
			self::SCENARIO_INSERT => 'created',
			self::SCENARIO_UPDATE => 'updated',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('facebookId',$this->facebookId,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function defaultScope() {
		$table = $this->getTableAlias(false, false);

		return array(
			'order' => "{$table}.name ASC",
		);
	}
	
	/**
	 * Import/update a group based on the facebook attributes
	 * @param array of attributes using the facebook mapping from me/groups
	 * @return Group the new/updated group
	 **/
	public static function syncWithFacebookAttributes($attributes) {

		$group = Group::model()->findByAttributes(array(
			'facebookId' => $attributes['id'],
		));

		if(is_null($group)) {
			$group = new Group();
		}

		$group->attributes = array(
			'name' => $attributes['name'],
			'facebookId' => $attributes['id'],
		);
		if($group->save()) {
			return $group;
		}

		throw new ModelValidationException("Group could not be synchronized: ", $group);
	}

	/** 
	 * Synchronize the list of members from facebook for this group.
	 * @return boolean
	 */
	public function syncFacebookMembers() {
		$facebookResponse = Yii::app()->FB->getGroupMembers($this->facebookId);
		$facebookMembers = $facebookResponse['data'];

		$unsyncedUserIds = array();
		foreach ($this->memberships as $membership) {
			$unsyncedUserIds[$membership->userId] = true; // sneaky reverse hash!
		}

		// Load all the new facebook members into our system as inactive members
		foreach ($facebookMembers as $facebookMember) {
			$user = User::findByFacebookId($facebookMember['id']);

			if($user) {
				Membership::saveAsInactiveMemberIfNotActive($this->id, $user->id);
				unset($unsyncedUserIds[$user->id]);
			}
		}

		// De-activate users who are in our system's list, but not facebook's list
		foreach ($unsyncedUserIds as $userId => $value) {
			Membership::saveAsDeactiveMember($this->id, $userId);
		}

		return true;
	}
	
	/**
	 * Get the list of Active users in this group filtered by 
	 * group status
	 * @param int $groupId
	 * @param String $status
	 * @return IDataProvider
	 * @deprecated
	 */
	public function getMembersByStatus($groupStatus) {
		if(strcasecmp($groupStatus, Membership::STATUS_ACTIVE) == 0) { 
			return new CActiveDataProvider('User', array('data' => $this->usersActive));
		}
		if(strcasecmp($groupStatus, Membership::STATUS_INACTIVE) == 0) { 
			return new CActiveDataProvider('User', array('data' => $this->usersInactive));
		}
		if(strcasecmp($groupStatus, Membership::STATUS_PENDING) == 0) { 
			return new CActiveDataProvider('User', array('data' => $this->usersPending));
		}
		
		throw new Exception("No such status");
	}

	public function getModifiedAsTimeAgo() {
		return Yii::app()->format->formatDateTimeAsAgo(strtotime($this->modified));
	}
	
	public function getPictureURL() {
		return Yii::app()->FB->getGroupPictureURL($this->facebookId);
	}

	/**
	 * Returns a boolean whether user should be emailed or not
	 * @return boolean
	 */
	
	public function shouldEmail()
	{
		if(strcmp($this->scenario, self::SCENARIO_UPDATE) == 0)
		{
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * Returns an array of users to be emailed
	 * @return array of users to be notified
	 */
	
	public function whoToNotifyByEmail()
	{
		return $this->getMembersByStatus(User::STATUS_ACTIVE);
	}

    public function getEmailName() {
        return $this->name;
    }
	
}