<?php

Yii::import("application.components.db.ar.ActiveRecord");
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
class Activity extends ActiveRecord implements LoggableRecord, FacebookGroupPostableRecord
{
	const NAME_MAX_LENGTH = 255;

	const SCENARIO_DELETE = 'delete';
	const SCENARIO_INSERT = 'insert'; // default set by Yii
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
			'DefaultGroupBehavior'=>array(
				'class' => 'ext.behaviors.DefaultGroupBehavior',
			),
			'DateTimeZoneBehavior'=>array(
				'class' => 'ext.behaviors.DateTimeZoneBehavior',
			),
			// Record C-UD operations to this record
			'ActiveRecordLogBehavior'=>array(
				'class' => 'ext.behaviors.ActiveRecordLogBehavior',
				'ignoreAttributes' => array('modified'),
			),
			'FacebookGroupPostBehavior'=>array(
				'class' => 'ext.facebook.components.db.ar.FacebookGroupPostBehavior',
				'ignoreAttributes' => array('modified'),
				'scenarios' => array('publish'),
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
			array('groupId, name', 'required'),

			// groupId can be any integer > 0 when set by user
			array('groupId',
				'numerical',
				'min' => 1,
				'integerOnly'=>true
			),

			array('name',
				'length', 
				'max'=>self::NAME_MAX_LENGTH
			),

			array('name, description', 
				'filter', 
				'filter'=>'trim'
			),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, groupId, authorId, facebookId, name, description, status, participantsCount, participantsCompletedCount, created, modified', 'safe', 'on'=>'search'),
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
			'groupId' => 'Group',
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
		if($this->isNewRecord) {
			$this->attributes = $attributes;
			$this->authorId = Yii::app()->user->id;
			$this->status = self::STATUS_PENDING;
			return $this->save();
		}
		else {
			throw new CDbException(Yii::t('activity','The activity cannot be inserted because it is not new.'));
		}
	}

	/** 
	 * When an activity is published, invite all the users in
	 * the group to participate
	 * @return boolean
	 **/
	public function publish($attributes=null) {
		$this->setScenario(self::SCENARIO_PUBLISH);
		$this->attributes = $attributes;

		if(!$this->authorId) {
			$this->authorId = Yii::app()->user->id;
		}
		
		$this->status = self::STATUS_ACTIVE;
		if($this->save()) {
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
		if(!$this->isNewRecord) {
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

	public function getViewURL() {
		return PHtml::activityURL($this);
	}
}