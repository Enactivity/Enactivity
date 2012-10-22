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
class GroupUser extends ActiveRecord implements EmailableRecord
{
	const SCENARIO_DEACTIVATE = 'deactivate';
	const SCENARIO_INSERT = 'insert';
	const SCENARIO_INVITE = 'invite';
	const SCENARIO_JOIN = 'join';
	const SCENARIO_LEAVE = 'leave';
	
	const STATUS_PENDING = 'Pending';
	const STATUS_ACTIVE = 'Active';
	const STATUS_DEACTIVATED = 'Deactivated';	
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

	public function scenarioLabels() {
		return array(
			self::SCENARIO_INSERT => 'inserted more people into',
			self::SCENARIO_INVITE => 'invited more people to join',
			self::SCENARIO_JOIN => 'joined',
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
		return array(
			self::STATUS_ACTIVE,
			self::STATUS_DEACTIVATED,
			self::STATUS_INACTIVE,
			self::STATUS_PENDING
		);
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

	public function getIsActive() {
		return strcasecmp($this->status, self::STATUS_ACTIVE) == 0;
	}

	public function getIsDeactivated() {
		return strcasecmp($this->status, self::STATUS_DEACTIVATED) == 0;
	}

	public function getIsInactive() {
		return strcasecmp($this->status, self::STATUS_INACTIVE) == 0;
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
	public function inviteToGroup($groupId, $userId) {
		$this->scenario = self::SCENARIO_INVITE;
		$this->groupId = $groupId;
		$this->userId = $userId;
		return $this->save();
	}
	
	/**
	 * Have a user join a group
	 * @return boolean
	 */
	public function joinGroup() {
		$this->scenario = self::SCENARIO_JOIN;
		$this->status = self::STATUS_ACTIVE;
		return $this->save();
	}

	/**
	 * Have a user leave a group
	 * @return boolean
	 */
	public function leaveGroup() {
		$this->scenario = self::SCENARIO_LEAVE;
		$this->status = self::STATUS_INACTIVE;
		return $this->save();
	}

	/** 
	 * Mark a user's membership as deactivated.
	 * Used in the case where Facebook membership is removed
	 * @return boolean
	 **/
	public function deactivate() {
		$this->scenario = self::SCENARIO_DEACTIVATE;
		$this->status = self::STATUS_DEACTIVATED;
		return $this->save();	
	}

	/**
	 * Find a GroupUser with the given group and user id,
	 * if no such group user exists, a model is created.
	 * @param int $groupId
	 * @param int $userId
	 * @return GroupUser unsaved GroupUser model
	 * @throws CDbException if no groupId or userId is passed in
	 */
	public static function loadGroupUser($groupId, $userId) {
		if(is_null($groupId)) {
			throw new CDbException("No group id provided in loadGroupUser call");
		}
		if(is_null($userId)) {
			throw new CDbException("No user id provided in loadGroupUser call");
		}
		
		$groupUser = GroupUser::model()->findByAttributes(array(
			'groupId' => $groupId,
			'userId' => $userId,
		));
		if(is_null($groupUser)) {
			$groupUser = new GroupUser();
			$groupUser->groupId = $groupId;
			$groupUser->userId = $userId;
		}

		return $groupUser;
	}

	/**
	 * Add/Update the user as an active member of the group
	 * @return GroupUser 
	 **/
	public static function saveAsActiveMember($groupId, $userId) {
		$groupUser = self::loadGroupUser($groupId, $userId);
		if($groupUser->joinGroup()) {
			return $groupUser;
		}
		throw new CException("Activating member failed: " . CVarDumper::dumpAsString($groupUser->errors));
	}

	/**
	 * Add/Update the user as a deactivated member of the group
	 * @return GroupUser 
	 **/
	public static function saveAsDeactiveMember($groupId, $userId) {
		$groupUser = self::loadGroupUser($groupId, $userId);
		if($groupUser->deactivate()) {
			return $groupUser;
		}
		throw new CException("Deactivating member failed: " . CVarDumper::dumpAsString($groupUser->errors));
	}

	/**
	 * Add/Update the user as an inactive member of the group
	 * @return GroupUser 
	 **/
	public static function saveAsInactiveMember($groupId, $userId) {
		$groupUser = self::loadGroupUser($groupId, $userId);
		if($groupUser->leaveGroup()) {
			return $groupUser;
		}
		throw new CException("Inactivating member failed: " . CVarDumper::dumpAsString($groupUser->errors));
	}

	/**
	 * Add/Update the user as an inactive member of the group if they didn't have an existing
	 * membership.  Useful for initial sync of user to group
	 * @return GroupUser 
	 **/
	public static function saveAsInactiveMemberIfNewRecord($groupId, $userId) {
		$groupUser = self::loadGroupUser($groupId, $userId);
		if($groupUser->isNewRecord) {
			if($groupUser->leaveGroup()) {
				return $groupUser;
			}
			throw new CException("Inactivating member failed: " . CVarDumper::dumpAsString($groupUser->errors));
		}
		return true;
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

    public function getEmailName() {
        return isset($this->group->name) ? $this->group->name : "";
    }
}