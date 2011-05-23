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
				'feedAttribute' => $this->task->name,
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
		return array(
			array('userId, taskId, isCompleted, isTrash', 
				'required'
			),
			
			// goal and owner can be any integer > 0
			array('userId, taskId',
				'numerical',
				'min' => 0,
				'integerOnly'=>true),
						
			// boolean ints can be 0 or 1
			array('isCompleted, isTrash',
				'numerical',
				'min' => 0,
				'max' => 1,
				'integerOnly'=>true),
			
			// boolean ints defaults to 0
			array('isCompleted, isTrash',
				'default',
				'value' => 0),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, userId, taskId, isCompleted, isTrash, created, modified', 'safe', 'on'=>'search'),
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
			self::SCENARIO_INSERT => 'posted', // default set by Yii
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
	 * Mark the TaskUser as completed, does not save
	 * @return TaskUser
	 */
	public function complete() {
		$this->isCompleted = 1;
		$this->setScenario(self::SCENARIO_COMPLETE);
		return $this;
	}
	
	/**
	 * Mark the TaskUser as not completed, does not save
	 * @return TaskUser
	 */
	public function uncomplete() {
		$this->isCompleted = 0;
		$this->setScenario(self::SCENARIO_UNCOMPLETE);
		return $this;
	}
	
	/**
	 * Mark the TaskUser as trash, does not save
	 * @return TaskUser
	 */
	public function trash() {
		$this->isTrash = 1;
		$this->setScenario(self::SCENARIO_TRASH);
		return $this;
	}
	
	/**
	 * Mark the TaskUser as not trash, does not save
	 * @return TaskUser
	 */
	public function untrash() {
		$this->isTrash = 0;
		$this->setScenario(self::SCENARIO_UNTRASH);
		return $this;
	}
	
	public function getGroupId() {
		return $this->task->groupId;
	}
}