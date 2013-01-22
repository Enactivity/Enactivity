<?php

Yii::import("application.components.db.ar.ActiveRecord");
Yii::import("application.components.db.ar.EmailableRecord");
Yii::import("application.components.db.ar.LoggableRecord");

Yii::import("ext.facebook.components.db.ar.FacebookGroupPostableRecord");

/**
 * This is the model class for table "activity".
 *
 * The followings are the available columns in table 'activity':
 * @property string $id
 * @property string $groupId
 * @property string $authorId
 * @property string $facebookId
 * @property string $name
 * @property string $description
 * @property string $status
 * @property integer $isTrash
 * @property string $participantsCount
 * @property string $participantsCompletedCount
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Group $group
 * @property User $author
 */
class Activity extends ActiveRecord implements LoggableRecord, FacebookGroupPostableRecord, EmailableRecord
{
	const NAME_MAX_LENGTH = 255;
	const DESCRIPTION_MAX_LENGTH = 10000;

	const SCENARIO_DELETE = 'delete';
	const SCENARIO_INSERT = 'insert'; // default set by Yii
	const SCENARIO_DRAFT = 'draft';
	const SCENARIO_PUBLISH = 'publish';
	const SCENARIO_TRASH = 'trash';
	const SCENARIO_UNTRASH = 'untrash';
	const SCENARIO_UPDATE = 'update'; // default set by Yii

	const STATUS_PENDING = 'Pending';
	const STATUS_ACTIVE = 'Active';
	const STATUS_DEACTIVATED = 'Trash';	

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Activity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function init() {
		// New activities should start as pending
		$this->status = self::STATUS_PENDING;
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'activity';
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
			// Set the groupId automatically when user is in only one group
			/*
			'DefaultGroupBehavior'=>array(
				'class' => 'ext.behaviors.DefaultGroupBehavior',
			),*/
			'DateTimeZoneBehavior'=>array(
				'class' => 'ext.behaviors.DateTimeZoneBehavior',
			),
			// Record C-UD operations to this record
			'ActiveRecordLogBehavior'=>array(
				'class' => 'ext.behaviors.ActiveRecordLogBehavior',
				'scenarios' => array(
					self::SCENARIO_PUBLISH => array(),
					self::SCENARIO_UPDATE => array(
						'name',
						'description',
					),
					self::SCENARIO_TRASH => array(),
					self::SCENARIO_UNTRASH => array(),
				),
			),
			'EmailNotificationBehavior'=>array(
				'class' => 'ext.behaviors.model.EmailNotificationBehavior',
				'scenarios' => array(
					self::SCENARIO_PUBLISH => array(),
					// self::SCENARIO_UPDATE => array(
					// 	'name',
					// 	'description',
					// ),
					// self::SCENARIO_TRASH => array(),
					// self::SCENARIO_UNTRASH => array(),
				),
			),
			'FacebookGroupPostBehavior'=>array(
				'class' => 'ext.facebook.components.db.ar.FacebookGroupPostBehavior',
				'scenarios' => array(
					self::SCENARIO_PUBLISH => array(),
					// FIXME: implement views
					// self::SCENARIO_UPDATE => array(
					// 	'name',
					// 	'description',
					// ),
					// self::SCENARIO_TRASH => array(),
					// self::SCENARIO_UNTRASH => array(),
				),
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
			array('groupId', 
				'required', 
				'except'=>self::SCENARIO_DRAFT,
			),

			// groupId can be any integer > 0 when set by user
			array('groupId',
				'numerical',
				'min' => 1,
				'integerOnly'=>true,
				'except'=>self::SCENARIO_DRAFT,
			),

			array('groupId',
				'safe',
				'on'=>self::SCENARIO_DRAFT,
			),

			array('name', 'required'),

			array('name',
				'length', 
				'max'=>self::NAME_MAX_LENGTH
			),

			array('name, description', 
				'filter', 
				'filter'=>'trim'
			),

			array('description',
				'length',
				'max'=>self::DESCRIPTION_MAX_LENGTH
			),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			// array('id, groupId, authorId, facebookId, name, description, status, participantsCount, participantsCompletedCount, created, modified', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'authorId'),

			'tasks' => array(self::HAS_MANY, 'Task', 'activityId',
				'scopes' => array('scopeNotTrash'),
			),

			'feed' => array(self::HAS_MANY, 'ActiveRecordLog', 'focalModelId',
				'condition' => 'feed.focalModel=\'Activity\''
					. ' OR feed.model=\'Activity\'',
				'order' => 'feed.created DESC',
			),

			'comments' => array(self::HAS_MANY, 'Comment', 'modelId',
				'condition' => 'comments.model=\'Activity\'',
				'order' => 'comments.created ASC',
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
			'groupId' => 'With the folks from',
			'authorId' => 'Author',
			'author.fullname' => 'Created By',
			'facebookId' => 'Facebook Id',
			'name' => 'Name',
			'description' => 'Description',
			'status' => 'Status',
			'participantsCount' => 'Participants Count',
			'participantsCompletedCount' => 'Participants Completed Count',
			'created' => 'Created',
			'modified' => 'Modified',
		);
	}

	public function scenarioLabels() {
		return array(
			self::SCENARIO_DELETE => 'deleted',
			self::SCENARIO_INSERT => 'created', // default set by Yii
			self::SCENARIO_DRAFT => 'drafted',
			self::SCENARIO_PUBLISH => 'published',
			self::SCENARIO_TRASH => 'trashed',
			self::SCENARIO_UNTRASH => 'untrashed',
			self::SCENARIO_UPDATE => 'updated',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('groupId',$this->groupId,true);
		$criteria->compare('authorId',$this->authorId,true);
		$criteria->compare('facebookId',$this->facebookId,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('participantsCount',$this->participantsCount,true);
		$criteria->compare('participantsCompletedCount',$this->participantsCompletedCount,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function scopeNotTrashAndDraft() {
		$table = $this->getTableAlias(false);

		$this->getDbCriteria()->mergeWith(array(
			'condition'=>"{$table}.status = '" . self::STATUS_PENDING . "'"
				. " AND {$table}.isTrash = 0",
		));
		return $this;
	}

	public function scopeNotTrashAndPublished() {
		$table = $this->getTableAlias(false);

		$this->getDbCriteria()->mergeWith(array(
			'condition'=>"{$table}.status = '" . self::STATUS_ACTIVE . "'"
				. " AND {$table}.isTrash = 0",
		));
		return $this;
	}

	/**
	 * Increment the participant count for an activity
	 * @param int $participantsIncrement number of times to increment participantsCount
	 * @param int $participantsIncrement number of times to increment participantsCompletedCount
	 * @return boolean
	 */
	public function incrementParticipantCounts($participantsIncrement, $participantsCompletedIncrement) {
		if(!is_numeric($participantsIncrement) || !is_numeric($participantsCompletedIncrement)) {
			throw new CDbException("Arguments must be numeric for increment participants counts");
		}
		
		if(($participantsIncrement == 0) && ($participantsCompletedIncrement == 0)) {
			return true;
		}
		
		/* @var $task Task */
		if($this->saveCounters(
			array( // column => increment value
				'participantsCount'=>$participantsIncrement,
				'participantsCompletedCount'=>$participantsCompletedIncrement,
		))) {
			return true;
		}
		
		throw new CDbException("Task counters were not incremented");
	}

	/**
	 * Save a new task, runs validation
	 * @param array $attributes
	 * @param array $tasks array of Task to assign to this Activity
	 * @return boolean
	 */
	public function draft($attributes=null, $tasks = array()) {
		$this->scenario = self::SCENARIO_DRAFT;
		$this->attributes = $attributes;
		$this->authorId = Yii::app()->user->id;
		$this->status = self::STATUS_PENDING;

		if($this->save()) {
			return true;
		}
		return false;
	}

	/** 
	 * When an activity is published, invite all the users in
	 * the group to participate
	 * @return boolean
	 **/
	public function publish($attributes=null) {
		$this->draft($attributes); // to generate new id

		$this->scenario = self::SCENARIO_PUBLISH;
		$this->attributes = $attributes;
		$this->status = self::STATUS_ACTIVE;

		if($this->save()) {
			Yii::app()->user->setFlash('success',  
				PHtml::encode($this->name) 
				. ' is now available for your group to view.');
			return true;
		}
		return false;
	}

	public function publishWithoutGroup($attributes = null) {
		$this->draft($attributes); // to generate new id

		$this->scenario = self::SCENARIO_PUBLISH;
		$this->attributes = $attributes;
		$this->status = self::STATUS_ACTIVE;

		if($this->save(false)) {
			return true;
		}
		return false;
	}
	
	/**
	 * Update the activity, runs validation
	 * @param array $attributes
	 * @return boolean
	 */
	public function updateActivity($attributes=null) {
		if($this->isExistingRecord) {
			$this->attributes = $attributes;
			return $this->save();
		}
		else {
			throw new CDbException(Yii::t('activity','The activity cannot be updated because it is new.'));
		}
	}

		/**
	 * Saves the activity as trash
	 * @return boolean whether the saving succeeds.
	*/
	public function trash() {
		$this->isTrash = 1;
		$this->setScenario(self::SCENARIO_TRASH);
		return $this->save();
	}
	
	/**
	 * Saves the activity as not trash
	 * @return boolean whether the saving succeeds.
	 */
	public function untrash() {
		$this->isTrash = 0;
		$this->setScenario(self::SCENARIO_UNTRASH);
		return $this->save();
	}

	/** 
	 * Get a truncated version of the name
	 * @return string
	 **/
	public function getShortName() {
		return StringUtils::truncate($this->name, 30);
	}

	/** 
	 * @return int size of task count
	 **/
	public function getTaskCount() {
		return sizeof($this->tasks);
	}

	public function getIsTrashable() {
		return $this->isExistingRecord && !$this->isTrash;
	}

	public function getIsUntrashable() {
		return $this->isExistingRecord && $this->isTrash;
	}

	public function getIsCommentable() {
		return !$this->isDraft
			&& !$this->isTrash;
	}

	/**
	 * Should be user be able to respond to task of this activity
	 * @return boolean
	 */
	public function getIsRespondable() {
		return !$this->isDraft
			&& !$this->isTrash;
	}

	/** 
	 * @return boolean is pending
	**/
	public function getIsDraft() {
		return strcasecmp($this->status, self::STATUS_PENDING) == 0;
	}

	/**
	 * @see LoggableRecord
	 **/
	public function getFocalModelClassForLog() {
		return get_class($this);
	}

	/**
	 * @see LoggableRecord
	 **/
	public function getFocalModelIdForLog() {
		return $this->primaryKey;
	}

	/**
	 * @see LoggableRecord
	 **/
	public function getFocalModelNameForLog() {
		return $this->name;
	}

	public function getFacebookGroupPostName() {
		return $this->name;
    }

	public function getFacebookPostId() {
		return $this->facebookId;
	}

	public function setFacebookPostId($facebookPostId) {
		$this->facebookId = $facebookPostId;
	}


	public function getViewURL() {
		return PHtml::activityURL($this);
	}

	public function getPublishURL() {
		return Yii::app()->createAbsoluteUrl('activity/publish',
			array(
				'id'=>$this->id,
			)
		);
	}

    public function getTrashURL() {
    	return Yii::app()->createAbsoluteUrl('activity/trash',
			array(
				'id'=>$this->id,
			)
		);
    }

    public function getUntrashURL() {
    	return Yii::app()->createAbsoluteUrl('activity/untrash',
			array(
				'id'=>$this->id,
			)
		);
    }

    public function whoToNotifyByEmail()
	{
		$group = Group::model()->findByPk($this->groupId);
		$users = $group->getMembersByStatus(User::STATUS_ACTIVE);
		return $users;
	}

    public function getEmailName() {
        return $this->name;
    }
}