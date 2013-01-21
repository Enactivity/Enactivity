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
				'scenarios' => array(
					self::SCENARIO_SIGN_UP => array(),
					self::SCENARIO_START => array(),
					self::SCENARIO_QUIT => array(),
					self::SCENARIO_STOP => array(),
					self::SCENARIO_COMPLETE => array(),
					self::SCENARIO_RESUME => array(),
				),
			),
			'EmailNotificationBehavior'=>array(
				'class' => 'ext.behaviors.model.EmailNotificationBehavior',
				'scenarios' => array(
					self::SCENARIO_SIGN_UP => array(),
					self::SCENARIO_START => array(),
					self::SCENARIO_QUIT => array(),
					self::SCENARIO_STOP => array(),
					self::SCENARIO_COMPLETE => array(),
					self::SCENARIO_RESUME => array(),
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
			self::SCENARIO_START => 'started participating in',
			self::SCENARIO_QUIT => 'quit',
			self::SCENARIO_COMPLETE => 'finished participating in',
			self::SCENARIO_RESUME => 'resumed participating in'
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

	public function getActivity() {
		// Use instead of relation b/c belongs_to doesn't have 'through' support
		return $this->task->activity;
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
	 * Applies scope where responses are not completed and not ignored
	 **/
	public function scopeIncompleteResponses() {
		$commaSeparatedStatuses = '\'' . implode('\', \'', self::getIncompleteStatuses()) . '\'';

		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'status IN (' . $commaSeparatedStatuses . ')',
		));
		return $this;
	}

	public function scopeIgnoredOrCompletedResponses() {
		$commaSeparatedStatuses = '\'' . implode('\', \'', self::getIgnoredOrCompletedStatuses()) . '\'';

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

	public function getIsNotCompleted() {
		return !$this->isCompleted;
	}

	public function getIsIgnored() {
		return strcasecmp($this->status, self::STATUS_IGNORED) == 0;
	}

	/** 
	 * @return boolean true if the user is participating in some way
	 **/
	public function getIsParticipating() {
		return $this->isExistingRecord && in_array($this->status, self::getParticipatingStatuses());
	}

	/** 
	 * @return boolean true if the user not is participating in any way
	 **/
	public function getIsNotParticipating() {
		return !$this->isParticipating;
	}

	public function getCanPend() {
		return $this->isExistingRecord;
	}

	public function getCanSignUp() {
		if($this->task->isRespondable && ($this->isPending || $this->isIgnored)) {
			
			return true;
		}
		return false;
	}

	public function getCanStart() {
		if($this->task->isRespondable && $this->isSignedUp) {
			return true;
		}
		return false;
	}

	public function getCanStop() {
		if($this->task->isRespondable && $this->isStarted) {
			return true;
		}
		return false;
	}

	public function getCanComplete() {
		if($this->task->isRespondable && $this->isStarted) {
			return true;
		}
		return false;
	}

	public function getCanResume() {
		if($this->task->isRespondable && $this->isCompleted) {
			return true;
		}
		return false;
	}

	public function getCanQuit() {
		if($this->task->isRespondable && ($this->isSignedUp || $this->isStarted)) {
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
	 * @return array of strings where the user has begun but not completed
	 */
	public static function getIncompleteStatuses() {
		return array(
			Response::STATUS_PENDING,
			Response::STATUS_SIGNED_UP,
			Response::STATUS_STARTED,
		);
	}

	/**
	 * @return array of strings where the user has is participating
	 */
	public static function getParticipatingStatuses() {
		return array(
			Response::STATUS_SIGNED_UP,
			Response::STATUS_STARTED,
			Response::STATUS_COMPLETED,
		);
	}

	/**
	 * @return array of strings where the user is not participating
	 */
	public static function getIgnoredOrCompletedStatuses() {
		return array(
			Response::STATUS_COMPLETED,
			Response::STATUS_IGNORED,
		);
	}	

	/**
	 * Find a response with the given task and user id,
	 * if no such task user exists, a model is created.
	 * @param int $taskId
	 * @param int $userId
	 * @return Response unsaved Response model
	 * @throws CDbException if no taskId or userId is passed in
	 */
	public static function loadResponse($taskId, $userId) {
		if($taskId == null) {
			throw new CDbException("No task id provided in loadResponse call");
		}
		if($userId == null) {
			throw new CDbException("No user id provided in loadResponse call");
		}
		
		$response = Response::model()->findByAttributes(array(
			'taskId' => $taskId,
			'userId' => $userId,
		));
		if(is_null($response)) {
			$response = new Response();
			$response->taskId = $taskId;
			$response->userId = $userId;
		}

		return $response;
	}

	/** 
	 * Changes the status of a response and updates counters 
	 * of appropriate task
	 * @param string the status string
	 * @return boolean true if saved 
	 * @throws Exception if any failures during transaction
	 **/
	protected function updateStatus($status) {

		Yii::trace("Updating response \"{$this->id}\" to \"{$status}\"", get_class($this));
		
		// don't update if not changing, unless it's a new record
		if((strcasecmp($this->status, $status) == 0) && $this->isExistingRecord) {
			return true;
		}

		// calculate Task count incrementations to ensure they are correct
		$incrementCount = 0;
		$incrementCompletedCount = 0;

		// Handle going from notParticipating -> Participating, Participating -> notParticipating or Participating -> Participating
		if($this->isNotParticipating && in_array($status, self::getParticipatingStatuses())) {
			$incrementCount++;
		}
		elseif($this->isParticipating && !in_array($status, self::getParticipatingStatuses())) {
			$incrementCount--;	
		}

		// Handle going from notComplete -> Complete, Complete -> notComplete or Complete -> Complete
		if($this->isNotCompleted && (strcasecmp($status, self::STATUS_COMPLETED) == 0)) {
			$incrementCompletedCount++;
		}
		elseif($this->isCompleted && (strcasecmp($status, self::STATUS_COMPLETED) != 0)) {
			$incrementCompletedCount--;
		}
		
		$transaction = $this->getDbConnection()->beginTransaction();
		try {
			$task = Task::model()->findByPk($this->taskId);
			$task->incrementParticipantCounts($incrementCount, $incrementCompletedCount);
		
			$this->status = $status;
		
			if($this->save()) {
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

	public static function pend($taskId, $userId) {
		$response = self::loadResponse($taskId, $userId);

		$response->scenario = self::SCENARIO_INSERT;
		return $response->updateStatus(self::STATUS_PENDING);
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
		$response = self::loadResponse($taskId, $userId);

		$response->scenario = self::SCENARIO_SIGN_UP;
		return $response->updateStatus(self::STATUS_SIGNED_UP);
	}

	public static function start($taskId, $userId) {
		$response = self::loadResponse($taskId, $userId);

		$response->scenario = self::SCENARIO_START;
		return $response->updateStatus(self::STATUS_STARTED);	
	}

	/**
	 * User resumes task
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 */
	public static function resume($taskId, $userId) {
		$response = self::loadResponse($taskId, $userId);

		$response->scenario = self::SCENARIO_RESUME;
		return $response->updateStatus(self::STATUS_STARTED);
	}
	
	/**
	 * User quits task
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 */
	public static function quit($taskId, $userId) {
		$response = self::loadResponse($taskId, $userId);

		$response->scenario = self::SCENARIO_QUIT;
		return $response->updateStatus(self::STATUS_PENDING);
	}

	/**
	 * User ignores task
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 */
	public static function ignore($taskId, $userId) {
		$response = self::loadResponse($taskId, $userId);

		$response->scenario = self::SCENARIO_IGNORE;
		return $response->updateStatus(self::STATUS_IGNORED);
	}

	/**
	 * Mark the response as stopped
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 * @throws CHttpException if response was not saved
	 */
	public static function stop($taskId, $userId) {
		$response = self::loadResponse($taskId, $userId);

		$response->scenario = self::SCENARIO_STOP;
		return $response->updateStatus(self::STATUS_SIGNED_UP);
	}

	/**
	 * Mark the response as completed
	 * @param int $taskId
	 * @param int $userId
	 * @return boolean true
	 * @throws CHttpException if response was not saved
	 */
	public static function complete($taskId, $userId) {
		$response = self::loadResponse($taskId, $userId);

		$response->scenario = self::SCENARIO_COMPLETE;
		return $response->updateStatus(self::STATUS_COMPLETED);
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