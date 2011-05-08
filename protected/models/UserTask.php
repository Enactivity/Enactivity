<?php

/**
 * This is the model class for table "user_task".
 *
 * The followings are the available columns in table 'user_task':
 * @property integer $id
 * @property integer $userId
 * @property integer $taskId
 * @property integer $isCompleted
 * @property integer $isTrash is UserTask link still active
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Task $task
 * @property User $user
 */
class UserTask extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserTask the static model class
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
		return 'user_task';
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
	 * Mark the UserTask as completed, does not save
	 * @return UserTask
	 */
	public function complete() {
		$this->isCompleted = 1;
		return $this;
	}
	
	/**
	 * Mark the UserTask as not completed, does not save
	 * @return UserTask
	 */
	public function uncomplete() {
		$this->isCompleted = 0;
		return $this;
	}
	
	/**
	 * Mark the UserTask as trash, does not save
	 * @return UserTask
	 */
	public function trash() {
		$this->isTrash = 1;
		return $this;
	}
	
	/**
	 * Mark the UserTask as not trash, does not save
	 * @return UserTask
	 */
	public function untrash() {
		$this->isTrash = 0;
		return $this;
	}
}