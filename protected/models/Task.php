<?php

/**
 * This is the model class for table "task".
 *
 * The followings are the available columns in table 'task':
 * @property integer $id
 * @property integer $goalId
 * @property string $name
 * @property integer $ownerId
 * @property integer $priority
 * @property integer $isCompleted
 * @property integer $isTrash
 * @property string $starts
 * @property string $ends
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Goal $goal
 * @property User $owner
 * @property UserTask[] $userTasks
 */
class Task extends CActiveRecord
{
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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('goalId, name, priority, created, modified', 'required'),
			array('goalId, ownerId, priority, isCompleted, isTrash', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('starts, ends', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, goalId, name, ownerId, priority, isCompleted, isTrash, starts, ends, created, modified', 'safe', 'on'=>'search'),
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
			'goal' => array(self::BELONGS_TO, 'Goal', 'goalId'),
			'owner' => array(self::BELONGS_TO, 'User', 'ownerId'),
			'userTasks' => array(self::HAS_MANY, 'UserTask', 'taskId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'goalId' => 'Goal',
			'name' => 'Name',
			'ownerId' => 'Owner',
			'priority' => 'Priority',
			'isCompleted' => 'Is Completed',
			'isTrash' => 'Is Trash',
			'starts' => 'Starts',
			'ends' => 'Ends',
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
		$criteria->compare('goalId',$this->goalId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('ownerId',$this->ownerId);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('isCompleted',$this->isCompleted);
		$criteria->compare('isTrash',$this->isTrash);
		$criteria->compare('starts',$this->starts,true);
		$criteria->compare('ends',$this->ends,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}