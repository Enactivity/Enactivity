<?php

/**
 * This is the model class for table "task".
 *
 * The followings are the available columns in table 'task':
 * @property integer $id
 * @property integer $groupId
 * @property integer $parentId
 * @property string $name
 * @property integer $isTrash
 * @property string $starts
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Group $group
 * @property Task $parent
 * @property TaskUser[] $taskUsers
 * @property Task[] $tasks
 * @property integer $taskUsersCount number of users who have signed up for the task 
 * @property integer $taskUsersCompletedCount number of users who have signed up for the task and marked it complete
 * @property User[] $participants
 */
class Task extends CActiveRecord
{
	const NAME_MAX_LENGTH = 255;
	
	const SCENARIO_COMPLETE = 'complete';
	const SCENARIO_DELETE = 'delete';
	const SCENARIO_INSERT = 'insert'; // default set by Yii
	const SCENARIO_READ = 'read';
	const SCENARIO_OWN = 'own';
	const SCENARIO_TRASH = 'trash';
	const SCENARIO_UNCOMPLETE = 'uncomplete';
	const SCENARIO_UNOWN = 'unown';
	const SCENARIO_UNTRASH = 'untrash';
	const SCENARIO_UPDATE = 'update';
	
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
			// Record C-UD operations to this record
			'ActiveRecordLogBehavior'=>array(
				'class' => 'ext.behaviors.ActiveRecordLogBehavior',
				'feedAttribute' => $this->name,
				'ignoreAttributes' => array('modified'),
			),
			'DateTimeZoneBehavior'=>array(
				'class' => 'ext.behaviors.DateTimeZoneBehavior',
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
			array('groupId, name, isTrash',
				'required'),
			
			// parent can be any integer > 0
			array('groupId',
				'numerical',
				'min' => 1,
				'integerOnly'=>true),
			
			// parent points to other taskId or null
			array('parentId',
				'numerical',
				'min' => 1,
				'integerOnly'=>true,
				'allowEmpty'=>true),
						
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
			'parent' => array(self::BELONGS_TO, 'Task', 'parentId'),
			
			'children' => array(self::HAS_MANY, 'Task', 'parentId',
				'condition' => 'children.isTrash=0',
			),
			'childrenCount' => array(self::STAT, 'Task', 'parentId'),

			'group' => array(self::BELONGS_TO, 'Group', 'groupId'),
		
			'taskUsers' => array(self::HAS_MANY, 'TaskUser', 'taskId',
				'condition' => 'taskUsers.isTrash=0',
			),
			'taskUsersCount' => array(self::STAT, 'TaskUser', 'taskId'),
			'taskUsersCompletedCount' => array(self::STAT, 'TaskUser', 'taskId'),
			
			'participants' => array(self::HAS_MANY, 'User', 'userId',
				'through' => 'taskUsers',
				'condition' => 'taskUsers.isTrash=0',
			),
			
			'feed' => array(self::HAS_MANY, 'ActiveRecordLog', 'focalModelId',
				'condition' => 'feed.focalModel=\'Task\'',
				'order' => 'feed.created DESC',
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
			'parentId' => 'Parent',
			'name' => 'Description',
			'isTrash' => 'Is Trash',
			'starts' => 'When',
			'created' => 'Created',
			'modified' => 'Modified',
			'taskUsers' => 'Participants',
			'taskUsersCount' => 'Number of Participants',
			'taskUsersCompletedCount' => 'Number of Participants Done',
		);
	}
	
	public function scenarioLabels() {
		return array(
			self::SCENARIO_COMPLETE => 'complete',
			self::SCENARIO_DELETE => 'delete',
			self::SCENARIO_INSERT => 'posted', // default set by Yii
			self::SCENARIO_READ => 'read',
			self::SCENARIO_OWN => 'own',
			self::SCENARIO_TRASH => 'trashed',
			self::SCENARIO_UNCOMPLETE => 'uncomplete',
			self::SCENARIO_UNOWN => 'unown',
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
		$criteria->compare('parentId',$this->parentId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('isTrash',$this->isTrash);
		$criteria->compare('starts',$this->starts,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
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
	
	public function setStartDate($date) {
		if(!empty($date)) {
			if(empty($this->starts)) {
				$soon = strtotime("+1 hour");
				$this->starts = date("Y-m-d H:00:00", $soon);
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
		// if it has subtasks, check they are completed
		if($this->hasChildren) {
			foreach($this->children as $subtask) {
				if(!$subtask->isTrash
				&& !$subtask->isCompleted) {
					return false;
				}
			}
			return true;
		}
		
		// if no subchildren, check signed up users are done
		if(sizeof($this->taskUsers) > 0) {
			foreach($this->taskUsers as $taskUser) {
				if(!$taskUser->isCompleted) {
					return false;
				}
			}
			return true;
		}
		return false;
	}
	
	/**
	 * Does the Task have a parent Task?
	 * @return boolean
	 */
	public function getHasParent() {
		return isset($this->parentId);
	}
	
	/**
	 * Does the Task have any children?
	 * @return boolean
	 */
	public function getHasChildren() {
		return sizeof($this->children) > 0;
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
		if(!$this->hasChildren) {
			return true;
		}
		return false;
	}
	
	/**
	 * Can subtasks be added to this task?
	 * @return boolean
	 */
	public function getIsSubtaskable() {
		if(sizeof($this->participants) == 0) {
			return true;
		}
		return false;
	}
	
	public function getRootParent() {
		if($this->hasParent) {
			if($this->parent->hasParent) {
				return $this->parent->rootParent;
			}
			else {
				return $this->parent;
			}
		}
		return null;
	}
	
	/**
	 * Marks the current user as participating in the task.
	 * Saves TaskUser
	 * @return Task
	 */
	public function participate() {
		
		// look for the TaskUser for this combination
		$userTask = $this->loadTaskUser();
		
		if($userTask->isTrash) {
			$userTask->unTrash();
		}
		$userTask->save();
		
		return $this;
	}
	
	/**
	 * Marks the current user as not participating in the task.
	 * Saves TaskUser
	 * @return Task
	 */
	public function unparticipate() {
			
		// look for the TaskUser for this combination
		$userTask = $this->loadTaskUser();
		
		$userTask->trash();
		$userTask->save();
		
		return $this;
	}
	
	/**
	 * Marks the current user as done with the task.
	 * Saves TaskUser
	 * @return Task
	 */
	public function userComplete() {
		
		// look for the TaskUser for this combination
		$userTask = $this->loadTaskUser();
		
		$userTask->complete();
		$userTask->save();
		
		return $this;
	}
	
	/**
	 * Marks the current user as not done with the task.
	 * Saves TaskUser
	 * @return Task
	 */
	public function userUncomplete() {
			
		// look for the TaskUser for this combination
		$userTask = $this->loadTaskUser();
		
		$userTask->uncomplete();
		$userTask->save();
		
		return $this;
	}
	
	/**
	 * Loads the TaskUser for the model and current user.  If no TaskUser
	 * exists yet, an unsaved new TaskUser is created. 
	 * @return TaskUser model for linking task to current user
	 */
	private function loadTaskUser() {
		// look for the TaskUser for this combination
		$userTask = TaskUser::model()->findByAttributes(
			array(
				'userId'=>Yii::app()->user->id,
				'taskId'=>$this->id,
			)
		);

		// if no TaskUser linker exists, create one
		if(is_null($userTask)) {
			$userTask = new TaskUser();
			$userTask->userId = Yii::app()->user->id;
			$userTask->taskId = $this->id;
		}
		return $userTask;
	}
	
	/**
	 * Mark the task as trash, does not save
	 * @return Task
	 */
	public function trash() {
		$this->isTrash = 1;
		$this->setScenario(self::SCENARIO_TRASH);
		return $this;
	}
	
	/**
	 * Mark the task as not trash, does not save
	 * @return Task
	 */
	public function untrash() {
		$this->isTrash = 0;
		$this->setScenario(self::SCENARIO_UNTRASH);
		return $this;
	}
	
	public function defaultScope() {
		return array(
			'order' => 'starts ASC' 
				. ', ' . $this->getTableAlias(false, false) . '.parentId ASC'
				. ', ' . $this->getTableAlias(false, false) . '.created ASC'
		);
	}
	
	public function noParentsScope()
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'parentId IS NULL',
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
	
		// calculate buffer dates before and after month
		$dayOfWeekStarts = $monthStarts->format('w');
		$bufferStart = new DateTime();
		$bufferStart->setDate($year, $month, 1 - $dayOfWeekStarts);
		$bufferStart->setTime(0, 0, 0);
	
		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$dayOfWeekEnds = $monthEnds->format('w');
		$bufferEnd = new DateTime();
		$bufferEnd->setDate($year, $month, $daysInMonth + $dayOfWeekEnds);
		$bufferEnd->setTime(23, 59, 59);
	
		return $this->scopeStartsBetween($bufferStart, $bufferEnd);
	}
	
	/**
	 * Scope for events taking place in a particular Month
	 * @param int $starts unix timestamp of start time
	 * @param int $ends unix timestamp of end time
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
	 * @return Event
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
	
	public function scopeNoWhen() {
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'starts IS NULL',
			)
		);
		return $this;
	}
}