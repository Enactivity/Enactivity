<?php
//FIXME: add inheritedTrash, participantsCount, participantsCompletedCount, participatableChildren 
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
 * @property string $name
 * @property integer $isTrash
 * @property string $starts
 * @property int $rootId
 * @property int $lft
 * @property int $rgt
 * @property int $level
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
class Task extends ActiveRecord implements EmailableRecord
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
			// Set the groupId automatically when user is in only one group
			'DefaultGroupBehavior'=>array(
				'class' => 'ext.behaviors.DefaultGroupBehavior',
			),
			'DateTimeZoneBehavior'=>array(
				'class' => 'ext.behaviors.DateTimeZoneBehavior',
			),
			// Nested Set Behavior
			'NestedSetBehavior'=>array(
				'class'=>'ext.behaviors.NestedSetBehavior',
				'hasManyRoots'=>true,
				'rootAttribute'=>'rootId',
				'leftAttribute'=>'lft',
				'rightAttribute'=>'rgt',
				'levelAttribute'=>'level',
			),
			// Record C-UD operations to this record
			'ActiveRecordLogBehavior'=>array(
				'class' => 'ext.behaviors.ActiveRecordLogBehavior',
				'feedAttribute' => $this->name,
				'ignoreAttributes' => array('modified'),
			),
			// Record C-UD operations to this record
			'EmailNotificationBehavior'=>array(
				'class' => 'ext.behaviors.model.EmailNotificationBehavior',
				'emailAttribute' => $this->name,
				'notifyAttribute' => 'descendantParticipants',
				'ignoreAttributes' => array('modified'),
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
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'root' => array(self::BELONGS_TO, 'Task', 'rootId'),
			
			'group' => array(self::BELONGS_TO, 'Group', 'groupId'),
			
			'taskUsers' => array(self::HAS_MANY, 'TaskUser', 'taskId'),
			'taskUsersCount' => array(self::STAT, 'TaskUser', 'taskId'),
			
			'participatingTaskUsers' => array(self::HAS_MANY, 'TaskUser', 'taskId',
				'condition' => 'participatingTaskUsers.isTrash=0',
			),
			'participants' => array(self::HAS_MANY, 'User', 'userId',
				'condition' => 'participatingTaskUsers.isTrash=0',
				'through' => 'participatingTaskUsers',
			),
			
			'feed' => array(self::HAS_MANY, 'ActiveRecordLog', 'focalModelId',
				'condition' => 'feed.focalModel=\'Task\'',
				'order' => 'feed.created DESC',
			),
			
			'comments' => array(self::HAS_MANY, 'Comment', 'modelId',
				'condition' => 'comments.model=\'Task\'',
				'order' => 'comments.created DESC',
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
			self::SCENARIO_DELETE => 'delete',
			self::SCENARIO_INSERT => 'posted', // default set by Yii
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
	 * @see NestedSetBehavior::saveNode()
	 */
	public function insertTask($attributes=null) {
		if($this->isNewRecord) {
			$this->attributes = $attributes;
			return $this->saveNode();
		}
		else {
			throw new CDbException(Yii::t('task','The task cannot be inserted because it is not new.'));
		}
	}
	
	/**
	 * Save this task as a new subtask, runs validation
	 * @param Task $parentTask
	 * @param array $attributes
	 * @return boolean
	 * @see NestedSetBehavior::appendTo()
	 */
	public function insertSubtask($parentTask, $attributes=null) {
		if(is_null($parentTask)) {
			throw new CDbException(Yii::t('task','The subtask cannot be inserted because no parent is specified'));
		}
		
		$this->attributes = $attributes;
		return $this->appendTo($parentTask);
	}
	
	/**
	 * Update the task, runs validation
	 * @param array $attributes
	 * @return boolean
	 * @see NestedSetBehavior::saveNode()
	 */
	public function updateTask($attributes=null) {
		if(!$this->isNewRecord) {
			$this->attributes = $attributes;
			return $this->saveNode();
		}
		else {
			throw new CDbException(Yii::t('task','The task cannot be updated because it is new.'));
		}
	}
	
	/**
	 * Saves the task as trash
	 * @return boolean whether the saving succeeds.
	 * @see NestedSetBehavior::saveNode()
	*/
	public function trash() {
		$this->isTrash = 1;
		$this->setScenario(self::SCENARIO_TRASH);
		return $this->saveNode();
	}
	
	/**
	 * Saves the task as not trash
	 * @return boolean whether the saving succeeds.
	 * @see NestedSetBehavior::saveNode()
	 */
	public function untrash() {
		$this->isTrash = 0;
		$this->setScenario(self::SCENARIO_UNTRASH);
		return $this->saveNode();
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
	 * Increment the participant count for a task and its ancestors
	 * @param int $participantsIncrement number of times to increment participantsCount
	 * @param int $participantsIncrement number of times to increment participantsCompletedCount
	 * @return int number of Tasks updated
	 */
	public function incrementParticipantCounts($participantsIncrement, $participantsCompletedIncrement) {
		if(!is_numeric($participantsIncrement) || !is_numeric($participantsCompletedIncrement)) {
			throw new CDbException("Arguments must be numeric for increment participants counts");
		}
		
		if(($participantsIncrement == 0) && ($participantsCompletedIncrement == 0)) {
			return 0;
		}
		
		if(!$this->isParticipatable) {
			throw new CDbException("Cannot increment tasks that are not participatable");
		}
		
		$ancestors = $this->ancestors()->findAll();
		$ancestors[] = $this; // so all objects are dealt with in a single loop
		
		/* @var $task Task */
		foreach ($ancestors as $task) {
			if($task->saveCounters(
				array( // column => increment value
					'participantsCount'=>$participantsIncrement,
					'participantsCompletedCount'=>$participantsCompletedIncrement,
				)
			) == false) {
				throw new CDbException("Task counters were not incremented");
			}
		}
		
		return count($ancestors);
	}
	
	/**
	 * Does the Task have a parent Task?
	 * @return boolean
	 * @deprecated use !isRoot instead
	 */
	public function getHasParent() {
		return !$this->isRoot;
	}
	
	/**
	 * Does the Task have any children?
	 * @return boolean
	 */
	public function getHasChildren() {
		//FIXME: doesn't account for deleted children
		return !$this->isLeaf();
	}
	
	/**
	 * Check if the current user is participating in the task
	 * and hasn't stopped (deleted the connection)
	 * @return true if user is a participant, false if not
	 */
	public function getIsUserParticipating() {
		
		$model = TaskUser::model()->findByAttributes(
			array(
				'userId'=>Yii::app()->user->id,
				'taskId'=>$this->id,
				'isTrash'=>0,
			)
		);
		
		if(isset($model)) {
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
		
		$model = TaskUser::model()->findByAttributes(
			array(
				'userId'=>Yii::app()->user->id,
				'taskId'=>$this->id,
				'isTrash'=>0,
				'isCompleted'=>1
			)
		);
		
		if(isset($model)) {
			return true;
		}
		return false;
	}	
	
	/**
	 * Can a user sign up for the task?
	 * @return boolean
	 */
	public function getIsParticipatable() {
		if($this->isLeaf) {
			return true;
		}
		return false;
	}
	
	/**
	 * Can subtasks be added to this task?
	 * @return boolean
	 */
	public function getIsSubtaskable() {
		return false;

		// if(sizeof($this->participants) == 0) {
		// 	return true;
		// }
		// return false;
	}
	
	/**
	 * Get all participants of the task and its children.
	 * @return array User[]
	 */
	public function getDescendantParticipants() {
		$participants = array();
		
		if($this->isParticipatable) {
			$participants = CMap::mergeArray($participants, $this->participants);
		}
		else {
			foreach($this->descendants()->with('participants')->findAll() as $task) {
				$participants = CMap::mergeArray($participants, $task->descendantParticipants);
			}
		}
		
		// we need to remove duplicates
		$serialized = array();
		$unserialized = array();
		foreach ($participants as $k=>$na) {
			$serialized[$k] = serialize($na);
		}
		$uniq = array_unique($serialized);
		foreach($uniq as $k=>$ser) {
			$unserialized[$k] = unserialize($ser);
		}
		return $unserialized;
	}
	
	/**
	 * Marks the current user as participating in the task.
	 * Saves TaskUser
	 * @return boolean
	 * @throws CHttpException if TaskUser was not saved
	 * @see TaskUser::signup()
	 */
	public function participate($userId) {
		return TaskUser::signUp($this->id, $userId);
	}
	
	/**
	 * Marks the current user as not participating in the task.
	 * Saves TaskUser
	 * @return boolean
	 * @throws CHttpException if TaskUser was not saved
	 * @see TaskUser::quit()
	 */
	public function unparticipate($userId) {
		return TaskUser::quit($this->id, $userId);
	}
	
	/**
	 * Marks the current user as done with the task.
	 * Saves TaskUser
	 * @return boolean
	 * @throws CHttpException if TaskUser was not saved
	 * @see TaskUser::complete()
	 */
	public function userComplete($userId) {
		return TaskUser::complete($this->id, $userId);
	}
	
	/**
	 * Marks the current user as not done with the task.
	 * Saves TaskUser
	 * @return boolean
	 * @throws CHttpException if TaskUser was not saved
	 * @see TaskUser::signUp()
	 */
	public function userUncomplete($userId) {
		return TaskUser::signUp($this->id, $userId);
	}
	
	public function defaultScope() {
		return array(
			'order' => 'starts ASC'
				. ', ' . $this->getTableAlias(false, false) . '.rootId ASC'
				. ', ' . $this->getTableAlias(false, false) . '.lft ASC'
				. ', ' . $this->getTableAlias(false, false) . '.created ASC'
		);
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
	public function scopeNoWhen() {
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'starts IS NULL',
			)
		);
		return $this;
	}
	
	/**
	 * Named scope. Gets leaf node(s).
	 * @return ActiveRecord the Task
	 */
	public function scopeLeaves() {
		$this->getDbCriteria()->mergeWith(array(
					'condition'=>'rgt - lft = 1',
		));
		return $this;
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function scopeNotCompleted() {
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'(participantsCount = 0' 
			. ' OR (participantsCount != participantsCompletedCount))',
		));
		return $this;
	}
	
	public function shouldEmail()
	{
		if(strcasecmp($this->scenario, self::SCENARIO_DELETE) == 0
		   || strcasecmp($this->scenario, self::SCENARIO_INSERT) == 0
		   || strcasecmp($this->scenario, self::SCENARIO_UPDATE) == 0)
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
	
}