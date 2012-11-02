<?php

Yii::import("application.components.db.ar.ActiveRecord");
Yii::import("application.components.db.ar.EmailableRecord");
Yii::import("application.components.db.ar.LoggableRecord");

/**
 * This is the model class for table "task_user".
 *
 * The followings are the available columns in table 'task_user':
 * @property integer $id
 * @property integer $userId
 * @property integer $taskId
 * @property string $status
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Task $task
 * @property User $user
 */
// TODO: rename to ActivityResponse or TaskResponse
class TaskUser extends ActiveRecord implements EmailableRecord, LoggableRecord
{

	const STATUS_PENDING = 'Pending'; // user has yet to respond
	const STATUS_SIGNED_UP = 'Signed Up';
	const STATUS_STARTED = 'Started';
	const STATUS_COMPLETED = 'Completed';
	const STATUS_IGNORED = 'Ignored';

	const SCENARIO_INSERT = 'insert'; 			// default set by Yii
	const SCENARIO_SIGN_UP = 'sign up';			// pending 		-> signed up
												// ignored 		-> signed up
	const SCENARIO_IGNORE = 'ignore'; 			// pending 		-> ignored
	const SCENARIO_START = 'start';				// signed up 	-> started
	const SCENARIO_QUIT = 'quit'; 				// signed up 	-> pending
	const SCENARIO_STOP ='stop';				// participating -> pending
	const SCENARIO_COMPLETE = 'complete'; 		// participating -> completed
	const SCENARIO_RESUME = 'resume'; 			// completed 	-> started
	const SCENARIO_DELETE = 'delete';

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
				'ignoreAttributes' => array('modified'),
			),
			'EmailNotificationBehavior'=>array(
				'class' => 'ext.behaviors.model.EmailNotificationBehavior',
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
			'status' => 'Status',
			'created' => 'Created',
			'modified' => 'Modified',
		);
	}

	public function scenarioLabels() {
		return array(
			self::SCENARIO_SIGN_UP => 'signed up for',
			self::SCENARIO_START => 'started work on',
			self::SCENARIO_QUIT => 'quit',
			self::SCENARIO_COMPLETE => 'finished working on',
			self::SCENARIO_RESUME => 'is once again working on'
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
		$criteria->compare('status',$this->status);
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

	public function getIsPending() {
		return strcasecmp($this->status, self::STATUS_PENDING) == 0;
	}

	public function getIsSignedUp() {
		return strcasecmp($this->status, self::STATUS_SIGNED_UP) == 0;
	}

	public function getIsStarted() {
		return strcasecmp($this->status, self::STATUS_STARTED) == 0;
	}

	public function getIsCompleted() {
		return strcasecmp($this->status, self::STATUS_COMPLETED) == 0;
	}

	public function getIsIgnored() {
		return strcasecmp($this->status, self::STATUS_IGNORED) == 0;
	}

	public function getCanPend() {
		return !$this->isNewRecord;
	}

	public function getCanSignUp() {
		if($this->isPending || $this->isIgnored) {
			return true;
		}
		return false;
	}

	public function getCanStart() {
		if($this->isSignedUp) {
			return true;
		}
		return false;
	}

	public function getCanStop() {
		if($this->isStarted) {
			return true;
		}
		return false;
	}

	public function getCanComplete() {
		if($this->isStarted) {
			return true;
		}
		return false;
	}

	public function getCanResume() {
		if($this->isCompleted) {
			return true;
		}
		return false;
	}

	public function getCanQuit() {
		if($this->isSignedUp || $this->isStarted) {
			return true;
		}
		return false;
	}

	public function getCanIgnore() {
		if($this->isPending) {
			return true;
		}
		return false;
	}

	/**
	 * @return array of strings where the user has actions they should do.
	 */
	public static function getNextableStatuses() {
		return array(
			TaskUser::STATUS_PENDING,
			TaskUser::STATUS_SIGNED_UP,
			TaskUser::STATUS_STARTED,
		);
	}

	/**
	 * @return array of strings where the user has is participating
	 */
	public static function getParticipatingStatuses() {
		return array(
			TaskUser::STATUS_SIGNED_UP,
			TaskUser::STATUS_STARTED,
			TaskUser::STATUS_COMPLETED,
		);
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

	public static function pend($taskId, $userId) {
		$taskUser = self::loadTaskUser($taskId, $userId);

		if(!$taskUser->isNewRecord) {
			throw new CHttpException("TaskUser already exists");
		}

		if($taskUser->isPending) {
			throw new CHttpException("User is already pending");
		}

		// scenario will be insert since it's new

		if($taskUser->isNewRecord) {
			$taskUser->scenario = self::SCENARIO_INSERT;
			$taskUser->status = self::STATUS_PENDING;

			if($taskUser->save()) {
				return true;
			}
			throw new CException("There was an error setting up the pending TaskUser");
		}
		throw new CException("TaskUser already exists");
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

		if(!$taskUser->canSignUp) {
			throw new CHttpException("User cannot sign up for this task.");
		}

		// Set scenario
		if($taskUser->isCompleted) {
			$taskUser->scenario = self::SCENARIO_RESUME;
		}
		else {
			$taskUser->scenario = self::SCENARIO_SIGN_UP;
		}
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
		 
		if($taskUser->isNewRecord || $taskUser->isPending || $taskUser->isIgnored) {
			$incrementCount++;
		}
		if($taskUser->isCompleted) {
			$incrementCompletedCount--;
		}
		
		$transaction = $taskUser->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);

			$taskUser->status = self::STATUS_SIGNED_UP;
	
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

	public static function start($taskId, $userId) {
		$taskUser = self::loadTaskUser($taskId, $userId);

		if(!$taskUser->canStart) {
			throw new CHttpException("User cannot start this task.");
		}

		$taskUser->scenario = self::SCENARIO_START;

		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;

		if($taskUser->isNewRecord || $taskUser->isPending || $taskUser->isIgnored) {
			$incrementCount++;
		}
		if($taskUser->isCompleted) {
			$incrementCompletedCount--;
		}

		$transaction = $taskUser->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$taskUser->status = self::STATUS_STARTED;
		
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
		throw new CHttpException(400, "There was an error starting this task");

	}

	/**
	 * User resumes task
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 */
	public static function resume($taskId, $userId) {
		$taskUser = self::loadTaskUser($taskId, $userId);

		if(!$taskUser->canResume) {
			throw new CHttpException("User cannot resume this task.");
		}

		$taskUser->scenario = self::SCENARIO_RESUME;
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
			
		if($taskUser->isNewRecord || $taskUser->isPending || $taskUser->isIgnored) {
			$incrementCount++;
		}
		if($taskUser->isCompleted) {
			$incrementCompletedCount--;
		}
		
		$transaction = $taskUser->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$taskUser->status = self::STATUS_STARTED;
		
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
	 * User quits task
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 */
	public static function quit($taskId, $userId) {
		$taskUser = self::loadTaskUser($taskId, $userId);

		if(!$taskUser->canQuit) {
			throw new CHttpException("User cannot quit this task.");
		}

		$taskUser->scenario = self::SCENARIO_QUIT;
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
			
		if($taskUser->isSignedUp || $taskUser->isStarted || $taskUser->isCompleted) {
			$incrementCount--;
		}
		if($taskUser->isCompleted) {
			$incrementCompletedCount--;
		}
		
		$transaction = $taskUser->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$taskUser->status = self::STATUS_PENDING;
		
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
	 * User ignores task
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 */
	public static function ignore($taskId, $userId) {
		$taskUser = self::loadTaskUser($taskId, $userId);

		if(!$taskUser->canIgnore) {
			throw new CHttpException("User cannot ignore this task.");
		}

		$taskUser->scenario = self::SCENARIO_IGNORE;
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
			
		if($taskUser->isSignedUp || $taskUser->isStarted || $taskUser->isCompleted) {
			$incrementCount--;
		}
		if($taskUser->isCompleted) {
			$incrementCompletedCount--;
		}
		
		$transaction = $taskUser->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$taskUser->status = self::STATUS_IGNORED;
		
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
	 * Mark the TaskUser as stopped
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 * @throws CHttpException if TaskUser was not saved
	 */
	public static function stop($taskId, $userId) {
		$taskUser = self::loadTaskUser($taskId, $userId);

		if(!$taskUser->canStop) {
			throw new CHttpException("User cannot stop working on this task.");
		}

		$taskUser->scenario = self::SCENARIO_STOP;
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
			
		if($taskUser->isNewRecord || $taskUser->isPending || $taskUser->isIgnored) {
			$incrementCount++;
		}
		if(!$taskUser->isCompleted) {
			$incrementCompletedCount--;
		}
		
		$transaction = $taskUser->getDbConnection()->beginTransaction();
		try {
			/* @var $task Task */
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$taskUser->status = self::STATUS_SIGNED_UP;
		
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

	/**
	 * Mark the TaskUser as completed
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 * @throws CHttpException if TaskUser was not saved
	 */
	public static function complete($taskId, $userId) {
		$taskUser = self::loadTaskUser($taskId, $userId);

		if(!$taskUser->canComplete) {
			throw new CHttpException("User cannot complete this task.");
		}

		$taskUser->scenario = self::SCENARIO_COMPLETE;
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
			
		if($taskUser->isNewRecord || $taskUser->isPending || $taskUser->isIgnored) {
			$incrementCount++;
		}
		if(!$taskUser->isCompleted) {
			$incrementCompletedCount++;
		}
		
		$transaction = $taskUser->getDbConnection()->beginTransaction();
		try {
			/* @var $task Task */
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$taskUser->status = self::STATUS_COMPLETED;
		
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

	/**
	 * @see LoggableRecord
	 **/
	public function getFocalModelClassForLog() {
		return get_class($this->task);
	}

	/**
	 * @see LoggableRecord
	 **/
	public function getFocalModelIdForLog() {
		return $this->task->primaryKey;
	}

	/**
	 * @see LoggableRecord
	 **/
	public function getFocalModelNameForLog() {
		return $this->task->name;
	}
	
	public function shouldEmail()
	{
		if(strcasecmp($this->scenario, self::SCENARIO_COMPLETE) == 0
		   || strcasecmp($this->scenario, self::SCENARIO_INSERT) == 0
		   || strcasecmp($this->scenario, self::SCENARIO_DELETE) == 0

		   )
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
        return isset($this->task->name) ? $this->task->name : "";
    }
}