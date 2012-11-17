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
class Response extends ActiveRecord implements EmailableRecord, LoggableRecord
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
	 * @return response the static model class
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
		return 'response';
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
			self::SCENARIO_IGNORE => 'ignored',
			self::SCENARIO_SIGN_UP => 'signed up for',
			self::SCENARIO_START => 'started work on',
			self::SCENARIO_QUIT => 'quit',
			self::SCENARIO_COMPLETE => 'finished working on',
			self::SCENARIO_RESUME => 'is once again working on'
		);
	}

	public function getStatusLabels() {
		return array(
			self::STATUS_PENDING => 'Haven\'t responded',
			self::STATUS_SIGNED_UP => 'Signed Up',
			self::STATUS_STARTED => 'Started',
			self::STATUS_COMPLETED => 'Completed',
			self::STATUS_IGNORED => 'Ignored',
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

	public function scopeNextable() {
		$commaSeparatedStatuses = '\'' . implode('\', \'', self::getNextableStatuses()) . '\'';

		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'status IN (' . $commaSeparatedStatuses . ')',
		));
		return $this;
	}

	public function scopeIgnorable() {
		$commaSeparatedStatuses = '\'' . implode('\', \'', self::getIgnorableStatuses()) . '\'';

		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'status IN (' . $commaSeparatedStatuses . ')',
		));
		return $this;
	}

	/**
	 * Get the groupId of the response
	 * @return int
	 */
	public function getGroupId() {
		if(is_null($this->task)) {
			$this->task = Task::model()->findByPk($this->taskId);
		}
		return $this->task->groupId;
	}

	public function getStatusLabel() {
		return $this->statusLabels[$this->status];
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
			response::STATUS_PENDING,
			response::STATUS_SIGNED_UP,
			response::STATUS_STARTED,
		);
	}

	/**
	 * @return array of strings where the user has is participating
	 */
	public static function getParticipatingStatuses() {
		return array(
			response::STATUS_SIGNED_UP,
			response::STATUS_STARTED,
			response::STATUS_COMPLETED,
		);
	}

	/**
	 * @return array of strings where the user is not participating
	 */
	public static function getIgnorableStatuses() {
		return array(
			response::STATUS_COMPLETED,
			response::STATUS_IGNORED,
		);
	}	

	/**
	 * Find a response with the given task and user id,
	 * if no such task user exists, a model is created.
	 * @param int $taskId
	 * @param int $userId
	 * @return response unsaved response model
	 * @throws CDbException if no taskId or userId is passed in
	 */
	public static function loadresponse($taskId, $userId) {
		if($taskId == null) {
			throw new CDbException("No task id provided in loadresponse call");
		}
		if($userId == null) {
			throw new CDbException("No user id provided in loadresponse call");
		}
		
		$response = response::model()->findByAttributes(array(
			'taskId' => $taskId,
			'userId' => $userId,
		));
		if(is_null($response)) {
			$response = new response();
			$response->taskId = $taskId;
			$response->userId = $userId;
		}

		return $response;
	}

	public static function pend($taskId, $userId) {
		$response = self::loadresponse($taskId, $userId);

		if(!$response->isNewRecord) {
			throw new CHttpException("response already exists");
		}

		if($response->isPending) {
			throw new CHttpException("User is already pending");
		}

		// scenario will be insert since it's new

		if($response->isNewRecord) {
			$response->scenario = self::SCENARIO_INSERT;
			$response->status = self::STATUS_PENDING;

			if($response->save()) {
				return true;
			}
			throw new CException("There was an error setting up the pending response");
		}
		throw new CException("response already exists");
	}
	
	/**
	 * User signs up for task, if user is already
	 * signed up for the task in some form, their
	 * sign up is refreshed as an untrashed, incomplete
	 * response
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 * @throws CHttpException if response was not saved
	 */
	public static function signUp($taskId, $userId) {
		$response = self::loadresponse($taskId, $userId);

		if(!$response->canSignUp) {
			throw new CHttpException("User cannot sign up for this task.");
		}

		// Set scenario
		if($response->isCompleted) {
			$response->scenario = self::SCENARIO_RESUME;
		}
		else {
			$response->scenario = self::SCENARIO_SIGN_UP;
		}
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
		 
		if($response->isNewRecord || $response->isPending || $response->isIgnored) {
			$incrementCount++;
		}
		if($response->isCompleted) {
			$incrementCompletedCount--;
		}
		
		$transaction = $response->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);

			$response->status = self::STATUS_SIGNED_UP;
	
			if($response->save()) {
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
		$response = self::loadresponse($taskId, $userId);

		if(!$response->canStart) {
			throw new CHttpException("User cannot start this task.");
		}

		$response->scenario = self::SCENARIO_START;

		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;

		if($response->isNewRecord || $response->isPending || $response->isIgnored) {
			$incrementCount++;
		}
		if($response->isCompleted) {
			$incrementCompletedCount--;
		}

		$transaction = $response->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$response->status = self::STATUS_STARTED;
		
			if($response->save()) {
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
		$response = self::loadresponse($taskId, $userId);

		if(!$response->canResume) {
			throw new CHttpException("User cannot resume this task.");
		}

		$response->scenario = self::SCENARIO_RESUME;
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
			
		if($response->isNewRecord || $response->isPending || $response->isIgnored) {
			$incrementCount++;
		}
		if($response->isCompleted) {
			$incrementCompletedCount--;
		}
		
		$transaction = $response->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$response->status = self::STATUS_STARTED;
		
			if($response->save()) {
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
		$response = self::loadresponse($taskId, $userId);

		if(!$response->canQuit) {
			throw new CHttpException("User cannot quit this task.");
		}

		$response->scenario = self::SCENARIO_QUIT;
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
			
		if($response->isSignedUp || $response->isStarted || $response->isCompleted) {
			$incrementCount--;
		}
		if($response->isCompleted) {
			$incrementCompletedCount--;
		}
		
		$transaction = $response->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$response->status = self::STATUS_PENDING;
		
			if($response->save()) {
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
		$response = self::loadresponse($taskId, $userId);

		if(!$response->canIgnore) {
			throw new CHttpException("User cannot ignore this task.");
		}

		$response->scenario = self::SCENARIO_IGNORE;
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
			
		if($response->isSignedUp || $response->isStarted || $response->isCompleted) {
			$incrementCount--;
		}
		if($response->isCompleted) {
			$incrementCompletedCount--;
		}
		
		$transaction = $response->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$response->status = self::STATUS_IGNORED;
		
			if($response->save()) {
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
	 * Mark the response as stopped
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 * @throws CHttpException if response was not saved
	 */
	public static function stop($taskId, $userId) {
		$response = self::loadresponse($taskId, $userId);

		if(!$response->canStop) {
			throw new CHttpException("User cannot stop working on this task.");
		}

		$response->scenario = self::SCENARIO_STOP;
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
			
		if($response->isNewRecord || $response->isPending || $response->isIgnored) {
			$incrementCount++;
		}
		if(!$response->isCompleted) {
			$incrementCompletedCount--;
		}
		
		$transaction = $response->getDbConnection()->beginTransaction();
		try {
			/* @var $task Task */
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$response->status = self::STATUS_SIGNED_UP;
		
			if($response->save()) {
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
	 * Mark the response as completed
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 * @throws CHttpException if response was not saved
	 */
	public static function complete($taskId, $userId) {
		$response = self::loadresponse($taskId, $userId);

		if(!$response->canComplete) {
			throw new CHttpException("User cannot complete this task.");
		}

		$response->scenario = self::SCENARIO_COMPLETE;
		
		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;
			
		if($response->isNewRecord || $response->isPending || $response->isIgnored) {
			$incrementCount++;
		}
		if(!$response->isCompleted) {
			$incrementCompletedCount++;
		}
		
		$transaction = $response->getDbConnection()->beginTransaction();
		try {
			/* @var $task Task */
			$task = Task::model()->findByPk($taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$response->status = self::STATUS_COMPLETED;
		
			if($response->save()) {
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