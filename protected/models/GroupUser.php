<?php

/**
 * This is the model class for table "group_user".
 *
 * The followings are the available columns in table 'group_user':
 * @property integer $id
 * @property integer $groupId
 * @property integer $userId
 * @property string $status
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Group $group
 * @property User $user
 */
class GroupUser extends CActiveRecord implements EmailableRecord
{
	const SCENARIO_INSERT = 'insert';
	const SCENARIO_INVITE = 'invite';
	const SCENARIO_JOIN = 'join';
	
	const STATUS_PENDING = 'Pending';
	const STATUS_ACTIVE = 'Active';
	const STATUS_INACTIVE = 'Inactive';

	/**
	 * Store of group maps
	 * @var array
	 */
	private static $_groups = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @return GroupUser the static model class
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
		return 'group_user';
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
		array('groupId, userId', 'required'),
		array('groupId, userId', 'numerical', 'integerOnly'=>true),
		
		// trim inputs
		array('status', 'filter', 'filter'=>'trim'),
		array('status', 'length', 'max'=>15),
		
		array('created, modified', 
			'safe'
		),

		// TODO: default to pending after adding user confirmation
		array('status', 
			'default',
			'value'=>self::STATUS_ACTIVE,
			'setOnEmpty'=>false, 'on'=>'insert'
		),
		array('status', 
			'in', 
			'range'=>$this->getStatuses()
		),

		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, groupId, userId, status, created, modified', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'Group', 'groupId'),
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'groupId' => 'Group',
			'userId' => 'User',
			'status' => 'Status',
			'created' => 'Invited on',
			'modified' => 'Invite last modified on',
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
		$criteria->compare('groupId',$this->groupId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return array of the available statuses
	 */
	public static function getStatuses() {
		return array(self::STATUS_ACTIVE,
		self::STATUS_INACTIVE,
		self::STATUS_PENDING);
	}
	
	public function scopeGroup($groupId)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'groupId = :groupId',
			'params' => array(':groupId' => $groupId),
		));
		return $this;
	}
	
	public function scopeUser($userId)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'userId = :userId',
			'params' => array(':userId' => $userId),
		));
		return $this;
	}

	public function scopeHasStatus($status) {
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'status = :status',
			'params' => array(':status' => $status),
		));
		return $this;
	}
	
	/**
	 * Get whether the user is a member of the group
	 * @param int $groupId
	 * @param int $userId
	 * @return boolean true if group member else false
	 */
	public function isGroupMember($groupId, $userId) {
		$groupuser = GroupUser::model()
			->scopeGroup($groupId)
			->scopeUser($userId)
			->scopeHasStatus(self::STATUS_ACTIVE)
			->find();
		return isset($groupuser);
	}
	
	/**
	 * Inserts a GroupUser object into 
	 * @param int $groupId
	 * @param int $userId
	 * @throws CDbException
	 */
	public function insertGroupUser($groupId, $userId) {
		$this->scenario = self::SCENARIO_INSERT;
		if($this->isNewRecord) {
			$this->groupId = $groupId;
			$this->userId = $userId;
			$this->status = self::STATUS_ACTIVE;
			return $this->save();
		}
		throw new CDbException(Yii::t('GroupUser','The group_user could not be inserted because it is not new.'));
	}
	
	/**
	 * Invite a user to a group
	 * @param int $groupId
	 * @param int $userId
	 * @return boolean
	 */
	public function inviteGroupUser($groupId, $userId) {
		$this->scenario = self::SCENARIO_INVITE;
		$this->groupId = $groupId;
		$this->userId = $userId;
		return $this->save();
	}
	
	/**
	 * Have a user join a group
	 * @return boolean
	 */
	public function joinGroupUser() {
		$this->scenario = self::SCENARIO_JOIN;
		$this->status = self::STATUS_ACTIVE;
		return $this->save();
	}

	public function onAfterSave($event) {
		parent::onAfterSave($event);
		// Send on new invite email
		if(strcasecmp($this->scenario, self::SCENARIO_INVITE) == 0) {
			$user = User::model()->findByPk($this->userId);
			$group = Group::model()->findByPk($this->groupId);
			if ($user->getIsActive()) {
				//send invitation to group
			}
			elseif ($user->getIsPending()) {
				$user->sendInvitation(Yii::app()->user->model->fullName, $group->name);
			}
		}
	}
	
	/**
	 * Handler inviteGroupUser event
	 * @param CEvent $event
	 * @return null
	 */
	/*
	public function onAfterInviteGroupUser($event) {
		// Send on new invite email
		CVarDumper::dump("in onAfterInviteGroupUser");
		if(strcasecmp($this->scenario, self::SCENARIO_INVITE) == 0) {
			$user = User::model()->findByPk($this->userId);
			CVarDumper::dump("found user");
			$group = Group::model()->findByPk($this->groupId);
			CVarDumper::dump("found groupid");
			
			if ($user->getIsActive()) {
				CVarDumper::dump("sending invitation to actives");
				//send invitation to group
			}
			elseif ($user->getIsPending()) {
				CVarDumper::dump("sending invitation");
				$user->sendInvitation(Yii::app()->user->model->fullName, $group->name);
			}
		}
		$user = User::model()->findByPk($this->userId);
		$group = Group::model()->findByPk($this->groupId);
		
		$user->sendInvitation(Yii::app()->user->model->fullName, $group->name);
	}*/
	
	/**
	 * Returns a boolean whether user should be emailed or not
	 * @return boolean
	 */
	
	public function shouldEmail()
	{
		if(strcasecmp($this->scenario, self::SCENARIO_INVITE) == 0
		   || strcasecmp($this->scenario, self::SCENARIO_JOIN) == 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function whoToNotifyByEmail()
	{
		//go through group and store in array with all active users
		//return array
		$group = Group::model()->findByPk($this->groupId);
		$emails = $group->getMembersByStatus(self::STATUS_ACTIVE);
		return $emails;
	}
}