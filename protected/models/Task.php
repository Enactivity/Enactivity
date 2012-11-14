<?php

Yii::import("application.components.db.ar.ActiveRecord");
Yii::import("application.components.db.ar.EmailableRecord");
Yii::import("application.components.db.ar.LoggableRecord");

Yii::import("ext.facebook.components.db.ar.FacebookGroupPostableRecord");

/**
 * This is the model class for table "task".
 * A task is a single item within a {@link Group} that {@link User}s can sign up for.
 *
 * The following are behaviors used by Task
 * @uses CTimestampBehavior
 * @uses NestedSetBehavior
 * @uses DefaultGroupBehavior
 * @uses DateTimeZoneBehavior
 * @uses ActiveRecordLogBehavior
 * @uses EmailNotificationBehavior
 *
 * The followings are the available columns in table 'task':
 * @property integer $id
 * @property integer $groupId
 * @property integer $taskId
 * @property string $name
 * @property integer $isTrash
 * @property string $starts
 * @property int $participantsCount
 * @property int $participantsCompletedCount
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Task $root
 * @property Group $group
 * @property TaskUser[] $taskUsers all TaskUser objects related to this Task
 * @property integer $taskUsersCount number of users who have signed up for the task 
 * @property TaskUser[] $participatingTaskUsers active TaskUser objects related to the model
 * @property User[] $participants users who are signed up for the Task
 * @property ActiveRecordLog[] $feed
 */
class Task extends ActiveRecord implements EmailableRecord, LoggableRecord, FacebookGroupPostableRecord
{
	const NAME_MAX_LENGTH = 255;
	
	const SCENARIO_DELETE = 'delete';
	const SCENARIO_INSERT = 'insert'; // default set by Yii
	const SCENARIO_TRASH = 'trash';
	const SCENARIO_UNTRASH = 'untrash';
	const SCENARIO_UPDATE = 'update'; // default set by Yii
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Task the static model class
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
		return 'task';
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
			'ActiveRecordLogBehavior'=>array(
				'class' => 'ext.behaviors.ActiveRecordLogBehavior',
				'ignoreAttributes' => array('modified'),
			),
			// Record C-UD operations to this record
			'EmailNotificationBehavior'=>array(
				'class' => 'ext.behaviors.model.EmailNotificationBehavior',
				'ignoreAttributes' => array('modified'),
			),
			'FacebookGroupPostBehavior'=>array(
				'class' => 'ext.facebook.components.db.ar.FacebookGroupPostBehavior',
				'ignoreAttributes' => array('modified'),
				'scenarios' => array('insert', 'trash', 'untrash', 'update'),
			),
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs via forms.
		return array(
			array('groupId, name, isTrash',
				'required'),
			
			// groupId can be any integer > 0
			array('groupId',
				'numerical',
				'min' => 1,
				'integerOnly'=>true),
			
			// boolean ints can be 0 or 1
			array('isTrash',
				'numerical',
				'min' => 0,
				'max' => 1,
				'integerOnly'=>true),
			
			// boolean ints defaults to 0
			array('isTrash',
				'default',
				'value' => 0),
			
			array('name',
				'length', 
				'max'=>self::NAME_MAX_LENGTH),
			
			array('name', 
				'filter', 
				'filter'=>'trim'),
			
			array('starts, startDate, startTime',
				'safe'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, groupId, name, isTrash, starts, created, modified',
			//	'safe',
			//	'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// stupid hacky way of escaping statuses
		$participatingWhereIn = '\'' . implode('\', \'', TaskUser::getParticipatingStatuses()) . '\'';

		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'group' => array(self::BELONGS_TO, 'Group', 'groupId'),
			'activity' => array(self::BELONGS_TO, 'Activity', 'activityId'),
			
			'taskUsers' => array(self::HAS_MANY, 'TaskUser', 'taskId'),
			'taskUsersCount' => array(self::STAT, 'TaskUser', 'taskId'),
			
			'participatingTaskUsers' => array(self::HAS_MANY, 'TaskUser', 'taskId',
				'condition' => 'participatingTaskUsers.status IN (' . $participatingWhereIn . ')',
			),
			'participants' => array(self::HAS_MANY, 'User', 'userId',
				'condition' => 'participatingTaskUsers.status IN (' . $participatingWhereIn . ')',
				'through' => 'participatingTaskUsers',
			),
			
			'feed' => array(self::HAS_MANY, 'ActiveRecordLog', 'focalModelId',
				'condition' => 'feed.focalModel=\'Task\'',
				'order' => 'feed.created DESC',
			),
			
			'comments' => array(self::HAS_MANY, 'Comment', 'modelId',
				'condition' => 'comments.model=\'Task\'',
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
			'name' => 'Task Description',
			'isTrash' => 'Is Trash',
			'starts' => 'When',
			'created' => 'Created',
			'modified' => 'Modified',
		);
	}
	
	public function scenarioLabels() {
		return array(
			self::SCENARIO_DELETE => 'deleted',
			self::SCENARIO_INSERT => 'created', // default set by Yii
			self::SCENARIO_TRASH => 'trashed',
			self::SCENARIO_UNTRASH => 'untrashed',
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
		$criteria->compare('groupId',$this->groupId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('isTrash',$this->isTrash);
		$criteria->compare('starts',$this->starts,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Save a new task, runs validation
	 * @param array $attributes
	 * @return boolean
	 */
	public function insertTask($attributes=null) {
		if($this->isNewRecord) {
			$this->attributes = $attributes;
			return $this->save();
		}
		else {
			throw new CDbException(Yii::t('task','The task cannot be inserted because it is not new.'));
		}
	}
	
	/**
	 * Update the task, runs validation
	 * @param array $attributes
	 * @return boolean
	 */
	public function updateTask($attributes=null) {
		if(!$this->isNewRecord) {
			$this->attributes = $attributes;
			return $this->save();
		}
		else {
			throw new CDbException(Yii::t('task','The task cannot be updated because it is new.'));
		}
	}
	
	/**
	 * Saves the task as trash
	 * @return boolean whether the saving succeeds.
	*/
	public function trash() {
		$this->isTrash = 1;
		$this->setScenario(self::SCENARIO_TRASH);
		return $this->save();
	}
	
	/**
	 * Saves the task as not trash
	 * @return boolean whether the saving succeeds.
	 * @see NestedSetBehavior::save()
	 */
	public function untrash() {
		$this->isTrash = 0;
		$this->setScenario(self::SCENARIO_UNTRASH);
		return $this->save();
	}
	
	public function afterFind() {
		parent::afterFind();
		
		// Format the date into a user-friendly format that matches inputs
		if(!is_null($this->startDate)) {
			$this->startDate = date('m/d/Y', strtotime($this->starts));			
		}
	}
	
	/**
	 * Delete any TaskUsers attached to the task.  
	 * @see ActiveRecord::beforeDelete()
	 */
	public function beforeDelete() {
		parent::beforeDelete();
		
		$this->scenario = self::SCENARIO_DELETE;
		
		$taskUsers = $this->taskUsers;
		
		try {
			foreach ($taskUsers as $taskUser) {
				$taskUser->delete();
			}
		}
		catch(Exception $e) {
			Yii::log('Task before delete failed: ' . $e->getMessage(), 'error');
			throw $e;
		}
		return true;
	}

	/** 
	 * Get a truncated version of the name
	 * @return string
	 **/
	public function getShortName() {
		return StringUtils::truncate($this->name, 30);
	}
	
	public function getStartDate() {
		if(empty($this->starts)) return null;
		
		$dateTimeArray = explode(' ', $this->starts);
		return $dateTimeArray[0];
	}
	
	public function getStartTime() {
		if(empty($this->starts)) return null;
		
		$dateTimeArray = explode(' ', $this->starts);
		return $dateTimeArray[1];
	}
	
	/**
	 * Returns the Task's start date time as a datetime int
	 */
	public function getStartTimestamp() {
		if(empty($this->starts)) {
			return null;
		}
		return strtotime($this->starts);
	}

	public function getStartYear() {
		if(empty($this->startTimestamp)) {
			return null;
		}
		return date('Y', $this->startTimestamp);
	}

	public function getStartMonth() {
		if(empty($this->startTimestamp)) {
			return null;
		}
		return date('m', $this->startTimestamp);	
	}

	public function getStartDay() {
		if(empty($this->startTimestamp)) {
			return null;
		}
		return date('d', $this->startTimestamp);
	}

	/**
	 * @return string formatted start time
	 * @see Formatter->formatTime()
	 **/
	public function getFormattedStartTime() {
		return Yii::app()->format->formatTime($this->starts);
	}
	
	public function setStartDate($date) {
		if(!empty($date)) {
			if(empty($this->starts)) {
				$this->starts = date("Y-m-d 12:00:00");
			}
			
			$dateTimeArray = explode(' ', $this->starts);
			$dateTimeArray[0] = $date;
			$datetime = implode(' ', $dateTimeArray);
			$this->starts = $datetime;
		}else{
			$this->starts = null;
		}
		return $this;
	}
	
	public function setStartTime($time) {
		if(!empty($time)) {
			if(empty($this->starts)) {
				$soon = strtotime("+1 hour");
				$this->starts = date("Y-m-d H:00:00", $soon);
			}
			
			$dateTimeArray = explode(' ', $this->starts);
			$dateTimeArray[1] = $time;
			$datetime = implode(' ', $dateTimeArray);
			$this->starts = $datetime;
		}else{
			$this->starts = null;
		}
		return $this;
	}
	
	/**
	 * Does this task have a start time?
	 * @return boolean
	 */
	public function getHasStarts() {
		return isset($this->starts);
	}
	
	/**
	 * Is the task completed?
	 * @return boolean
	 */
	public function getIsCompleted() {
		if($this->participantsCount <= 0) {
			return false;
		}
		return $this->participantsCount == $this->participantsCompletedCount;
	}

	/**
	 * @return int
	 **/
	public function getCommentCount() {
		return sizeof($this->comments);
	}

	/**
	 * Increment the participant count for a task and its ancestors
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
	
	public function getCurrentTaskUser() {
		return TaskUser::loadTaskUser($this->id, Yii::app()->user->id);
	}

	/**
	 * Check if the current user is participating in the task
	 * and hasn't stopped (deleted the connection)
	 * @return true if user is a participant, false if not
	 */
	public function getIsUserParticipating() {

		$taskUser = TaskUser::loadTaskUser($this->id, Yii::app()->user->id);
		
		if($taskUser->isSignedUp || $taskUser->isStarted) {
			return true;
		}
		return false;
	}
	
	/**
	 * Check if the current user is participating in the task
	 * and hasn't stopped (deleted the connection)
	 * @return true if user is a participant, false if not
	 */
	public function getIsUserComplete() {
		
		$taskUser = TaskUser::loadTaskUser($this->id, Yii::app()->user->id);
		
		if($taskUser->isCompleted) {
			return true;
		}
		return false;
	}
	
	public function defaultScope() {
		return array(
			'order' => 'starts ASC'
				. ', ' . $this->getTableAlias(false, false) . '.created ASC'
		);
	}

	/**
	 * Tasks which are not alive
	 **/
	public function scopeAlive() {
		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'isTrash=0',
		));
		return $this;
	}
	
	/**
	* Scope for events taking place in a particular Month
	* @param mixed $month as integer (January = 1, Dec = 12)
	* @param mixed $year as integer
	*/
	public function scopeByCalendarMonth($month, $year) {
	
		// convert params to integers
		$month = intval($month);
		$year = intval($year);
	
		// FIXME: account for user timezone
		$monthStarts = new DateTime($year . "-" . $month . "-1");
		$monthStarts->setTime(0, 0, 0);
	
		$monthEnds = new DateTime($year . "-" . ($month) . "-1");
		$monthEnds->modify('+1 month');
		$monthEnds->setTime(0, 0, 0);
	
		return $this->scopeStartsBetween($monthStarts, $monthEnds);
	}
	
	/**
	 * Scope for events taking place in a particular Month
	 * @param int $starts unix timestamp of start time
	 * @param int $ends unix timestamp of end time
	 * @return ActiveRecord the Task
	 */
	public function scopeStartsBetween(DateTime $starts, DateTime $ends) {
		$this->getDbCriteria()->mergeWith(array(
				'condition'=>'starts <= :ends AND starts >= :starts',
				'params' => array(
					':starts' => $starts->format("Y-m-d H:i:s"),
					':ends' => $ends->format("Y-m-d H:i:s"),
		),
		));
		return $this;
	}
	
	/**
	 * Scope definition for events that share group value with
	 * the user's groups
	 * @param int $userId
	 * @return ActiveRecord the Task
	 */
	public function scopeUsersGroups($userId) {
		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'id IN (SELECT id FROM ' . $this->tableName() 
				.  ' WHERE groupId IN (SELECT groupId FROM ' . GroupUser::model()->tableName()
				. ' WHERE userId=:userId))',
			'params' => array(':userId' => $userId)
		));
		return $this;
	}
	
	/**
	 * Named scope. Gets the nodes that have no start value.
	 * @return ActiveRecord the Task
	 */
	public function scopeFuture() {
		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'futureTasks.starts >= NOW()',
		));
		return $this;
	}

	/**
	 * Named scope. Gets the nodes that have no start value.
	 * @return ActiveRecord the Task
	 */
	public function scopeSomeday() {
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'starts IS NULL',
			)
		);
		return $this;
	}
	
	/**
	 * Named scope. Tasks which are not completed
	 */
	public function scopeNotCompleted() {
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'(participantsCount = 0' 
			. ' OR (participantsCount != participantsCompletedCount))',
		));
		return $this;
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
	
	public function shouldEmail()
	{
		if(strcasecmp($this->scenario, self::SCENARIO_DELETE) == 0
		   || strcasecmp($this->scenario, self::SCENARIO_INSERT) == 0
		   || strcasecmp($this->scenario, self::SCENARIO_UPDATE) == 0
		   || strcasecmp($this->scenario, self::SCENARIO_TRASH) == 0
		   || strcasecmp($this->scenario, self::SCENARIO_UNTRASH) == 0)
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
		$emails = $group->getMembersByStatus(User::STATUS_ACTIVE);
		return $emails;
	}

    public function getEmailName() {
        return $this->name;
    }

    public function getFacebookFeedableName() {
        return $this->name;
    }

    public function getViewURL() {
    	return PHtml::taskURL($this);
    }

    /**
	 * Get the next tasks the user is signed up for
	 * @param User model
	 * @return CArrayDataProvider
	 */
	public static function nextTasksForUser($user) {
		return new CArrayDataProvider(
			$user->nextTasks(
				array(
					'pagination'=>false,
				)
			)
		);
	}

	 /**
	 * Get the tasks in the future the user is signed up for
	 * @param User model
	 * @return CArrayDataProvider
	 */
	public static function futureTasksForUser($user) {
		return new CArrayDataProvider(
			$user->futureTasks(
				array(
					'pagination'=>false,
				)
			)
		);
	}

	public static function ignorableTasksForUser($user) {
		return new CArrayDataProvider(
			$user->ignorableTasks(
				array(
					'pagination'=>false,
				)
			)
		);
	}

	public static function ignorableSomedayTasksForUser($user) {
		return new CArrayDataProvider(
			$user->ignorableSomedayTasks(
				array(
					'pagination'=>false,
				)
			)
		);
	}

	/**
	 * Get an ActiveDataProvider with data about tasks for a given month
	 * @param int
	 * @param Month 
	 * @return CActiveDataProvider
	 */
	public static function tasksForUserInMonth($userId, $month) {
		$taskWithDateQueryModel = new Task();
		$datedTasks = new CActiveDataProvider(
			$taskWithDateQueryModel
			->scopeAlive()
			->scopeUsersGroups($userId)
			->scopeByCalendarMonth($month->monthIndex, $month->year),
			array(
				'pagination'=>false,
			)
		);

		return $datedTasks;
	}

	/**
	 * Get an ActiveDataProvider with data about tasks with no start date
	 * @param int
	 * @return CActiveDataProvider
	 */
	public static function tasksForUserWithNoStart($userId) {
		$taskWithoutDateQueryModel = new Task();
		$datelessTasks = new CActiveDataProvider(
		$taskWithoutDateQueryModel
			->scopeAlive()
			->scopeUsersGroups($userId)
			->scopeSomeday()
			->scopeNotCompleted(),
			array(
				'criteria'=>array(
					'condition'=>'isTrash=0'
				),
				'pagination'=>false,
			)
		);

		return $datelessTasks;
	}
	
}