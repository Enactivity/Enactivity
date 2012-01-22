<?php

/**
 * This is the model class for table "task_user".
 *
 * The followings are the available columns in table 'task_user':
 * @property integer $id
 * @property integer $userId
 * @property integer $taskId
 * @property integer $isCompleted
 * @property integer $isTrash is TaskUser link still active
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Task $task
 * @property User $user
 */
class TaskUser extends CActiveRecord
{

	const SCENARIO_COMPLETE = 'complete';
	const SCENARIO_DELETE = 'delete';
	const SCENARIO_INSERT = 'insert'; // default set by Yii
	const SCENARIO_TRASH = 'trash';
	const SCENARIO_UNCOMPLETE = 'uncomplete';
	const SCENARIO_UNTRASH = 'untrash';
	const SCENARIO_UPDATE = 'update';

	/**
	 * Returns the static model of the specified AR class.
	 * @return TaskUser the static model class
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
		return 'task_user';
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
				'focalModelClass' => 'Task',
				'focalModelId' => 'taskId',
				'feedAttribute' => isset($this->task->name) ? $this->task->name : "", //TODO: find out effects of "" default
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
		// will receive user inputs.
		return array();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'task' => array(self::BELONGS_TO, 'Task', 'taskId'),
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'userId' => 'User',
			'taskId' => 'Task',
			'isCompleted' => 'Is Completed',
			'isTrash' => 'Is Trash',
			'created' => 'Created',
			'modified' => 'Modified',
		);
	}

	public function scenarioLabels() {
		return array(
		self::SCENARIO_COMPLETE => 'finished working on',
		self::SCENARIO_DELETE => 'delete',
		self::SCENARIO_INSERT => 'signed up for', // default set by Yii
		self::SCENARIO_TRASH => 'quit',
		self::SCENARIO_UNCOMPLETE => 'is once again working on',
		self::SCENARIO_UNTRASH => 'signed back up for',
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('taskId',$this->taskId);
		$criteria->compare('isCompleted',$this->isCompleted);
		$criteria->compare('isTrash',$this->isTrash);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Get the groupId of the TaskUser
	 * @return int
	 */
	public function getGroupId() {
		if(is_null($this->task)) {
			$this->task = Task::model()->findByPk($this->taskId);
		}
		return $this->task->groupId;
	}

	/**
	 * Find a TaskUser with the given task and user id,
	 * if no such task user exists, a model is created.
	 * @param int $taskId
	 * @param int $userId
	 * @return TaskUser unsaved TaskUser model
	 * @throws CDbException if no taskId or userId is passed in
	 */
	public static function loadTaskUser($taskId, $userId) {
		if($taskId == null) {
			throw new CDbException("No task id provided in loadTaskUser call");
		}
		if($userId == null) {
			throw new CDbException("No user id provided in loadTaskUser call");
		}
		
		$taskUser = TaskUser::model()->findByAttributes(array(
			'taskId' => $taskId,
			'userId' => $userId,
		));
		if(is_null($taskUser)) {
			$taskUser = new TaskUser();
			$taskUser->taskId = $taskId;
			$taskUser->userId = $userId;
		}

		return $taskUser;
	}
	
	/**
	 * User signs up for task, if user is already
	 * signed up for the task in some form, their
	 * sign up is refreshed as an untrashed, incomplete
	 * TaskUser
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 * @throws CHttpException if TaskUser was not saved
	 */
	public static function signUp($taskId, $userId) {
		$taskUser = self::loadTaskUser($taskId, $userId);

		if($taskUser->isNewRecord) {
			$taskUser->scenario = self::SCENARIO_INSERT;
		}
		elseif($taskUser->isTrash == 1) { // user quit the task before
			$taskUser->scenario = self::SCENARIO_UNTRASH;
		}
		else { // user had completed task previously
			$taskUser->scenario = self::SCENARIO_UNCOMPLETE;
		}
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
		 
		if($taskUser->isNewRecord || $taskUser->isTrash == 1) {
			$incrementCount = 1;
		}
		if($taskUser->isCompleted == 1) {
			$incrementCompletedCount = -1;
		}
		
		$transaction = $taskUser->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
	
			$taskUser->isCompleted = 0;
			$taskUser->isTrash = 0;
	
			if($taskUser->save()) {
				$transaction->commit();
				return true;
			}
		}
		catch (Exception $e) {
			$transaction->rollback();
			throw $e; 
		}
		
		$transaction->rollback();
		throw new CHttpException("There was an error signing up for this task");
	}
	
	/**
	 * User quits task
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 * @throws CHttpException if user never signed up for task
	 */
	public static function quit($taskId, $userId) {
		$taskUser = self::loadTaskUser($taskId, $userId);

		if($taskUser->isNewRecord) {
			throw new CHttpException(400, "Can't quit a task you never signed up for");
		}

		$taskUser->scenario = self::SCENARIO_TRASH;
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
			
		if($taskUser->isNewRecord || $taskUser->isTrash == 0) {
			$incrementCount = -1;
		}
		if($taskUser->isCompleted == 1) {
			$incrementCompletedCount = -1;
		}
		
		$transaction = $taskUser->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$taskUser->isTrash = 1;
			$taskUser->isCompleted = 0;
		
			if($taskUser->save()) {
				$transaction->commit();
				return true;
			}
		}
		catch (Exception $e) {
			$transaction->rollback();
			throw $e;
		}
		
		$transaction->rollback();
		throw new CHttpException(400, "There was an error quitting this task");
	}

	/**
	 * Mark the TaskUser as completed
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 * @throws CHttpException if TaskUser was not saved
	 */
	public static function complete($taskId, $userId) {
		$taskUser = self::loadTaskUser($taskId, $userId);

		$taskUser->scenario = self::SCENARIO_COMPLETE;
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
			
		if($taskUser->isNewRecord || $taskUser->isTrash == 1) {
			$incrementCount = 1;
		}
		if($taskUser->isCompleted == 0) {
			$incrementCompletedCount = 1;
		}
		
		$transaction = $taskUser->getDbConnection()->beginTransaction();
		try {
			/* @var $task Task */
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$taskUser->isTrash = 0;
			$taskUser->isCompleted = 1;
		
			if($taskUser->save()) {
				$transaction->commit();
				return true;
			}
		}
		catch (Exception $e) {
			$transaction->rollback();
			throw $e;
		}
		
		$transaction->rollback();
		throw new CHttpException(400, "There was an error completing this task");
	}
}